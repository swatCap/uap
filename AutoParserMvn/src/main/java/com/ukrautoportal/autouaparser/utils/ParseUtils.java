/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.ukrautoportal.autouaparser.utils;

import com.ukrautoportal.autouaparser.data.AbstractPoint;
import com.ukrautoportal.autouaparser.data.AutoSalonFull;
import com.ukrautoportal.parser.utils.CommonParseUtils;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;
import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

/**
 *
 * @author swat
 */
public class ParseUtils 
{
    
    private static final Logger LOGGER = LogManager.getLogger(ParseUtils.class.getName());        
    
    
    private static List<String> getPointUrls(String url, int maxPageNumber){        
        List<String> res = new  ArrayList<>();
                
        for(int i = 0; i < maxPageNumber; i++){
            Document codeDoc = CommonParseUtils.getDocument(url + String.valueOf(i));
        
            Elements els = codeDoc != null ? codeDoc.getElementsByClass("l-middle-coll_wide") : null;
            Elements points = els != null && !els.isEmpty() ? els.get(0).getElementsByClass("b-point-info") : null;

            if (points != null && !points.isEmpty())
            {
                for(Element pointInfo : points)
                {
                    Elements links = pointInfo.select("a[href]");                                        
                    
                    if (links != null && !links.isEmpty()){
                        String href = links.get(0).attr("href");
                        
                        if (href != null && !href.isEmpty()){
                            res.add(href);
                        }
                    }
                }
            }
        }
        
        return res;
    }
    
    
    private static <T extends AbstractPoint> List<T> getPoints(Class<T> clazz, String url, int maxPageNumber)
    {
        List<String> pointsUrls = getPointUrls(url, maxPageNumber);
                        
        if (pointsUrls != null && !pointsUrls.isEmpty())
        {
            List<T> res = new ArrayList<>();
            
            for(String pointUrl : pointsUrls)
            {
                T t = null;
                
                if (AutoSalonFull.class.equals(clazz)) 
                {
                    t = (T) getAutoSalonFull(pointUrl);
                }

                if (t != null)
                {
                    res.add(t);
                }
            }
            
            return res;
        }
        
        return Collections.EMPTY_LIST;
    }
    
    
    
    public static List<AutoSalonFull> getAutosalonsPoints(int maxPageNumber)
    {
        return getPoints(AutoSalonFull.class,
                         "http://point.autoua.net/avtosalony/vse/ukraina/#/avtosalony/vse/ukraina/?page=",
                         maxPageNumber);
    }
    
    private static AutoSalonFull getAutoSalonFull(String url)
    {
        Document codeDoc = CommonParseUtils.getDocument(url);
        if (codeDoc != null)
        {
            String html = codeDoc.outerHtml();
            
            html.length();
                   
        }
        
        return null;
    }
    
    
    
}
