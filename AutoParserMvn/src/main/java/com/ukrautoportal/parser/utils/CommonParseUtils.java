/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.ukrautoportal.parser.utils;

import java.io.IOException;
import java.util.Map;
import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import com.google.gson.Gson;

/**
 *
 * @author swat
 */
public class CommonParseUtils {
    private static final Logger LOGGER = LogManager.getLogger(CommonParseUtils.class.getName());    
    
    
    private static final int ATTEMPTS__GET_DOCUMENT_FROM_URL    = 4;
    
    private static final int SLEEP_BETWEEN_ATTEMPTS             = 5000;
    
    private static final Gson GSON = new Gson();
    
    public static Document getDocument(String url)
    {
        int attempt = 0;
        while (attempt < ATTEMPTS__GET_DOCUMENT_FROM_URL)
        {
            try
            {
                return Jsoup.connect(url).timeout(1000000).get();
            }
            catch (IOException ex)
            {
                LOGGER.error("Error while getting url " + url + " at attempt #" + attempt, ex);
            }
            
            try
            {
                Thread.sleep(SLEEP_BETWEEN_ATTEMPTS);
            }        
            catch (InterruptedException ignore) {}           
        }        
        
        return null;        
    }
    
    
    public static Integer selectByName(Map<Integer, String> map, String name){
        if (name != null && map != null){
            for(Map.Entry<Integer, String> entry : map.entrySet()){
                String entryName = entry.getValue();
                
                if (entryName != null && entryName.equalsIgnoreCase(name)){
                    return entry.getKey();
                }
            }
        }
        
        return null;
    }
    
    public static String toJSONString(Object obj){
        return GSON.toJson(obj);
    }
}
