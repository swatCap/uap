/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package autoparser;

import java.io.FileWriter;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

/**
 *
 * @author swat
 */
public class AutoParser {

//    static final String Path = "D:" + File.separator + "work" + File.separator + "1" + File.separator + "ImagesDownloader" + File.separator + "Results" + File.separator; // where we save results
    
    private static final String FILE_NAME_URLS = "autosalonsURLs.txt";
    private static final String WEBSITE_URL = "http://point.autoua.net/avtosalony/vse/ukraina/?page="; // website for search 
    private static final int TRY_ATTEMPT_SLEEP = 500;
    
    private static Document getCode(String url, int trial) // gets html-code of given page
        {
        if(5 == trial) // if we can't get html for 5 times we skip this page
        {
            return null;
        }
        try
        {
            Thread.sleep(TRY_ATTEMPT_SLEEP);
            return Jsoup.connect(url).timeout(1000000).get(); // html code
        } 
        
        catch (InterruptedException ex)
        {
            ex.printStackTrace();
            System.err.println("Caught InterruptedException: " + ex.getMessage());
            return getCode(url, trial + 1); // new try
        }
        catch (IOException ex)
        {
            ex.printStackTrace();
            System.err.println("Caught IOException: " + ex.getMessage());
            return getCode(url, trial + 1); // new try            
        }
    }
    
    public static List<String> getPointUrls(int maxPageNumber){        
        List<String> res = new  ArrayList<>();
                
        for(int i = 0; i < maxPageNumber; i++){
            Document codeDoc = getCode(WEBSITE_URL + String.valueOf(i), TRY_ATTEMPT_SLEEP);
        
            Elements els = codeDoc != null ? codeDoc.getElementsByClass("l-middle-coll_wide") : null;
            Elements points = els != null && !els.isEmpty() ? els.get(0).getElementsByClass("b-point-info") : null;

            if (points != null && !points.isEmpty()){
                for(Element pointInfo : points){
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
    
    
    private static void processPoint(String url)
    {
        Document codeDoc = getCode("http://point.autoua.net/tochki" + url, TRY_ATTEMPT_SLEEP);
        if (codeDoc != null)
        {
            String html = codeDoc.outerHtml();
            
            html.length();
                   
        }
    }
    
    
    private static void saveStringListToFile(List<String> list)
    {                
        try (FileWriter writer = new FileWriter("points.txt"))
        {           
            for(String str: list) 
            {
                writer.write(str);
            }
        } 
        catch (IOException ex) 
        {
            Logger.getLogger(AutoParser.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        
        List<String> urls = getPointUrls(39);
        
        
        
        if (urls != null && !urls.isEmpty()){
            for(String url : urls){
                processPoint(url);
            }
        }
        
        System.out.println(urls);
    }
}
