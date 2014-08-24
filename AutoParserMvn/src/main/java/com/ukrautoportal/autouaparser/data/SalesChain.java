/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.ukrautoportal.autouaparser.data;

import static com.ukrautoportal.autouaparser.data.AutoService.AUTO_SUBSTITUTION;
import static com.ukrautoportal.autouaparser.data.AutoService.ID_AUTO_SUBSTITUTION;
import static com.ukrautoportal.autouaparser.data.AutoService.MAP;
import java.util.HashMap;
import java.util.Map;

/**
 *
 * @author swat
 */
public class SalesChain 
{
    public static final Map<Integer, String> MAP;     
    
    public static final String AUTOTRADING                 = "Автотрейдинг";  
    public static final int    ID_AUTOTRADING              = 1;  
    
    public static final String AIS                         = "АИС";  
    public static final int    ID_AIS                      = 2;
    
    public static final String ATLANT_M                    = "Атлант-М";  
    public static final int    ID_ATLANT_M                 = 3;
    
    public static final String BOGDAN_AUTO                 = "Богдан-Авто";   
    public static final int    ID_BOGDAN_AUTO              = 4;
    
    public static final String VIDI                        = "ВиДи";
    public static final int    ID_VIDI                     = 5;
    
    public static final String ILTA                        = "Илта"; 
    public static final int    ID_ILTA                     = 6;
    
    public static final String NIKO                        = "НИКО";     
    public static final int    ID_NIKO                     = 7;
    
    public static final String UKR_AUTO                    = "УкрАвто"; 
    public static final int    ID_UKR_AUTO                 = 8;
    
    static 
    {
        MAP = new HashMap<>();
        
        MAP.put(ID_AUTOTRADING, AUTOTRADING);
        MAP.put(ID_AIS, AIS);
        MAP.put(ID_ATLANT_M, ATLANT_M);
        MAP.put(ID_BOGDAN_AUTO, BOGDAN_AUTO);
        MAP.put(ID_VIDI, VIDI);
        MAP.put(ID_ILTA, ILTA);
        MAP.put(ID_NIKO, NIKO);
        MAP.put(ID_UKR_AUTO, UKR_AUTO);
    }
}
