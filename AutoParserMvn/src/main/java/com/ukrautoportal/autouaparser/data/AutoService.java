/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.ukrautoportal.autouaparser.data;

import java.util.HashMap;
import java.util.Map;

/**
 *
 * @author swat
 */
public class AutoService {
    
    public static final Map<Integer, String> MAP; 

    
    public static final String AUTO_SUBSTITUTION        = "Авто на подмену";
    public static final int    ID_AUTO_SUBSTITUTION     = 1;
    
    public static final String AUTO_SEATS               = "Автокресла";
    public static final int    ID_AUTO_SEATS            = 2;

    public static final String AUTO_INSURANCE           = "Автострахование";
    public static final int    ID_AUTO_INSURANCE        = 3;
    
    public static final String ACCESOIRES               = "Аксессуары";
    public static final int    ID_ACCESOIRES            = 4;

    public static final String AUTO_RENT                = "Аренда автомобилей";
    public static final int    ID_AUTO_RENT             = 5;

    public static final String ASSISTANCE               = "Ассистанс";
    public static final int    ID_ASSISTANCE            = 6;

    public static final String SPARE_PARTS              = "Запчасти";
    public static final int    ID_SPARE_PARTS           = 7;

    public static final String COMMISION_SELLING        = "Комиссионная продажа";
    public static final int    ID_COMMISION_SELLING     = 8;
    
    public static final String CREDIT                   = "Кредит";
    public static final int    ID_CREDIT                = 9;

    public static final String LEASING                  = "Лизинг";
    public static final int    ID_LEASING               = 10;

    public static final String USED_CARS_SELL           = "Продажа автомобилей с пробегом";
    public static final int    ID_USED_CARS_SELL        = 11;
    
    public static final String TEST_DRIVE               = "Тест-драйв";
    public static final int    ID_TEST_DRIVE            = 12;

    public static final String TI_FOR_POLICE            = "ТО для ГАИ";
    public static final int    ID_TI_FOR_POLICE         = 13;
    
    public static final String TRADE_IN                 = "Трейд-ин";
    public static final int    ID_TRADE_IN              = 14;

    public static final String EVACUATOR                = "Эвакуатор";
    public static final int    ID_EVACUATOR             = 15;

    
    static 
    {
        MAP = new HashMap<>();
        
        MAP.put(ID_AUTO_SUBSTITUTION, AUTO_SUBSTITUTION);
        MAP.put(ID_AUTO_SEATS, AUTO_SEATS);
        MAP.put(ID_AUTO_INSURANCE, AUTO_INSURANCE);
        MAP.put(ID_ACCESOIRES, ACCESOIRES);
        MAP.put(ID_AUTO_RENT, AUTO_RENT);
        MAP.put(ID_ASSISTANCE, ASSISTANCE);
        MAP.put(ID_SPARE_PARTS, SPARE_PARTS);
        MAP.put(ID_COMMISION_SELLING, COMMISION_SELLING);
        MAP.put(ID_CREDIT, CREDIT);
        MAP.put(ID_LEASING, LEASING);
        MAP.put(ID_USED_CARS_SELL, USED_CARS_SELL);
        MAP.put(ID_TEST_DRIVE, TEST_DRIVE);
        MAP.put(ID_TI_FOR_POLICE, TI_FOR_POLICE);
        MAP.put(ID_TRADE_IN, TRADE_IN);
        MAP.put(ID_EVACUATOR, EVACUATOR);                            
    }
}
