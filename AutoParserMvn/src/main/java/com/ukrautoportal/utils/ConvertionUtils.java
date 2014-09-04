/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.ukrautoportal.utils;

import com.ukrautoportal.autouaparser.data.AutoSalon;
import com.ukrautoportal.autouaparser.data.SalesChain;

/**
 *
 * @author swat
 */
public class ConvertionUtils {
    public static String getPostTitle(AutoSalon autoSalon){
        String name = autoSalon != null ? autoSalon.getName() : null;
        if (name != null){
            String res = name;
            
            Integer salesChain = autoSalon.getSalesChainId();
            String salesChainName = SalesChain.MAP.get(salesChain);
            
            if (salesChainName != null){                                
                res += " <img src='http://ukrautoportal.com/wp-content/uploads/sales-chain/" + salesChain + ".jpg'" + 
                        " align='absmiddle' title='' alt='" + salesChainName + "' style='margin-left: 15px;'>";                                
            }
            
            if (autoSalon.isOfficial()){
                res += " <div class='officialPoint'>Официальный</div>";
            }
            
            return res;
        }
    
        return null;
    }
    
    
    public static String getPostContent(AutoSalon autoSalon){
        if (autoSalon != null){
            String res = name;
            
            Integer salesChain = autoSalon.getSalesChainId();
            String salesChainName = SalesChain.MAP.get(salesChain);
            
            if (salesChainName != null){                                
                res += " <img src='http://ukrautoportal.com/wp-content/uploads/sales-chain/" + salesChain + ".jpg'" + 
                        " align='absmiddle' title='' alt='" + salesChainName + "' style='margin-left: 15px;'>";                                
            }
            
            if (autoSalon.isOfficial()){
                res += " <div class='officialPoint'>Официальный</div>";
            }
            
            return res;
        }
    
        return null;
    }
}
