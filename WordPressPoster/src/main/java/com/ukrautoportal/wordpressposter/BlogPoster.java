/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.ukrautoportal.wordpressposter;

//import org.apache.xmlrpc.XmlRpcException;

import java.net.MalformedURLException;
import java.util.HashMap;
import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;
import redstone.xmlrpc.XmlRpcClient;
import redstone.xmlrpc.XmlRpcException;
import redstone.xmlrpc.XmlRpcFault;

//import org.apache.xmlrpc.client.XmlRpcClient;
/**
 *
 * @author swat
 */
public class BlogPoster {
    private static final Logger LOGGER = LogManager.getLogger(BlogPoster.class.getName());        
    
    private static final String xmlRpcUrl = "http://ukrautoportal.com/xmlrpc.php";

    private static final String apiKey = "60ce0324e2c4";
    private static final String userName = "localhost";
    private static final String password = "181192";
    
    
    public static final Integer postPage(String title, String content, boolean draft){
        try {
            XmlRpcClient client = new XmlRpcClient(xmlRpcUrl, true);

            HashMap hmContent = new HashMap();
            hmContent.put("title", title);
            hmContent.put("description", content);
            if (draft) {
                hmContent.put("post_status", "draft");
            }
                                 
            return (Integer) client.invoke("wp.newPage", new Object[] {1,
                                                                       userName,
                                                                       password,
                                                                       hmContent,
                                                                       true} );            
        } catch (XmlRpcException | XmlRpcFault | MalformedURLException e) {
            LOGGER.error("[ERROR] Can't post page ", e);
        } 
        
        
        return null;
    }
    
}
