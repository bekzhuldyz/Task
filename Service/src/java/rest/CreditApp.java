/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package rest;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import java.security.Provider.Service;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.UriInfo;
import javax.ws.rs.Produces;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.core.MediaType;

/**
 * REST Web Service
 *
 * @author zhuldyz
 */
@Path("rest")
public class CreditApp {

    public class ServiceResult{
        private String Message;
        private Boolean Result;
    }
    
    @Context
    private UriInfo context;

    /**
     * Creates a new instance of CreditApp
     */
    public CreditApp() {
    }

    
    @GET
    @Path("{iin}/{birthDay}/{gender}")
    @Produces(MediaType.APPLICATION_JSON)
    public String checkIIN(@PathParam("iin") String iin, 
                            @PathParam("birthDay") String birthDay,
                            @PathParam("gender") int gender) {
        
        Gson gson = new GsonBuilder().create();
        ServiceResult res = new ServiceResult();
        res.Message = "OK";
        res.Result = true;
		
        Calendar mydate = new GregorianCalendar();
        Date thedate = new Date();
        try {
            thedate = new SimpleDateFormat("dd.MM.yyyy").parse(birthDay);
        } catch (ParseException ex) {
            Logger.getLogger(Service.class.getName()).log(Level.SEVERE, null, ex);
            res.Message = "IIN is incorrect (Date is invalid)";
            res.Result = false;
            return gson.toJson(res);
        }
        // check birthDay in iin
        mydate.setTime(thedate);
        int month = mydate.get((Calendar.MONTH)) + 1; // Calendar starts from 0 to 11 instead of 1 to 12

        String date6D = Integer.toString(mydate.get(Calendar.YEAR)).substring(2, 4) +
                        Integer.toString(month) +
                        Integer.toString(mydate.get(Calendar.DAY_OF_MONTH));
        
        if(!iin.substring(0, 6).equals(date6D))
        {
            res.Message = "IIN is incorrect (Dates are not equal)";
            res.Result = false;
            return gson.toJson(res);
        }
        else
        {
            // check gender
            int digit7 = Integer.parseInt(iin.substring(6, 7));
            switch(gender)
            {
                case 1:
                    if(digit7 % 2 == 0) {
                    	//result = "<CreditService><code>1</code><message>GENDER is incorrect</message><result>FALSE</result></CreditService>";
                    	res.Message = "IIN is incorrect (GENDER is incorrect)";
                        res.Result = false;
                        return gson.toJson(res);
                    }
                    break;
                case 2:
                    if(digit7 % 2 == 1) {
                    	//result = "<CreditService><code>1</code><message>GENDER is incorrect</message><result>FALSE</result></CreditService>";
                    	res.Message = "IIN is incorrect (GENDER is incorrect)";
                        res.Result = false;
                        return gson.toJson(res);
                    }
                    break;
            }  
            
            // control
            int sum = 0, block = 0, mod = 0;
            int a12 = Integer.parseInt(iin.substring(iin.length() - 1, iin.length()));
            
            for (int i=1; i<12; i++) {                
                block = Integer.parseInt(iin.substring(i - 1, i));
                sum += block * i;
            }
            mod = sum % 11;
            if(mod != a12) {
                res.Message = "IIN is incorrect (control value is incorrect)";
                res.Result = false;
                return gson.toJson(res);
            }
            else if (mod == 10) {
                res.Message = "IIN is incorrect (IIN is invalid, not in use)";
                res.Result = false;
                return gson.toJson(res);
            }
        }	
        return gson.toJson(res);
    }
	
    
    @GET
    @Path("{salary}/{term}/{rate}/{expense}/{monthlyPayments}/{amount}")
    @Produces(MediaType.APPLICATION_JSON)
    public String checkAPP(@PathParam("salary") double salary,  // zp
                            @PathParam("term") int term, // srok
                            @PathParam("rate") int rate, // stavka
                            @PathParam("expense") double expense, // rashod deneg (komunalka, arenda)
                            @PathParam("monthlyPayments") double monthlyPayments, // ejemesyachnyi platej
                            @PathParam("amount") double amount) // summa credita
    {
        Gson gson = new GsonBuilder().create();
        double coeff1 = 0.6; // 60% of salary 
        
        ServiceResult res = new ServiceResult();
        res.Message = "CONFIRMED";
        res.Result = true;
        
        
        // calculate max monthly payments
        double netProfit = salary - expense; // chistyi dohod                
        double MAX_MONTHLY_PAYMENTS =  coeff1 * netProfit;
        
        if (monthlyPayments >= MAX_MONTHLY_PAYMENTS){
            res.Message = "REJECTED"; //макс. еж. платеж " + MAX_MONTHLY_PAYMENTS + " меньше еж. платежа " + monthlyPayments;
            res.Result = false;
            return gson.toJson(res);
        }
        else {
            // calculate max amount of credit
            double rateX = (double) rate / 100;
            double termX = (double) term / 12;
            double MAX_AMOUNT = (double) (MAX_MONTHLY_PAYMENTS * term) / (1 + ((rateX * termX)));
            if (amount >= MAX_AMOUNT) {
                res.Message = "REJECTED"; //макс. сумма кредита " + MAX_AMOUNT + " меньше суммы кредита " + amount;
                res.Result = false;
                return gson.toJson(res);
            }
        }
        return gson.toJson(res);
    }
}
