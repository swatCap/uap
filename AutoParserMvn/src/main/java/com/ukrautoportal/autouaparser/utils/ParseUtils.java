/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.ukrautoportal.autouaparser.utils;

import com.ukrautoportal.autouaparser.data.AbstractPoint;
import com.ukrautoportal.autouaparser.data.Address;
import com.ukrautoportal.autouaparser.data.AutoBrand;
import com.ukrautoportal.autouaparser.data.AutoSalon;
import com.ukrautoportal.autouaparser.data.AutoService;
import com.ukrautoportal.autouaparser.data.SalesChain;
import com.ukrautoportal.parser.utils.CommonParseUtils;
import com.ukrautoportal.utils.FileUtils;
import com.ukrautoportal.utils.Transliterator;
import java.io.File;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
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
    public static final String PARSED_SITE_URL = "http://point.autoua.net";
    
    private static final Logger LOGGER = LogManager.getLogger(ParseUtils.class.getName());        
    
    
    public static List<String> getPointUrls(String url, int maxPageNumber){        
        List<String> res = new  ArrayList<>();
                
        for(int i = 1; i <= maxPageNumber; i++){
            Document codeDoc = CommonParseUtils.getDocument(url + String.valueOf(i));
        
            Elements points = codeDoc != null ? codeDoc.select("a[href].point-name") : null;

            if (points != null && !points.isEmpty())
            {
                for(Element pointInfo : points)
                {
                    String href = pointInfo.attr("href");
                    if (href.contains("tochki")){
                        res.add(href);
                    }
                    
                }
            }
        }
        
        return res;
    }
    
    
    private static <T extends AbstractPoint> List<T> getPoints(Class<T> clazz, List<String> pointsUrls)
    {                        
        if (pointsUrls != null && !pointsUrls.isEmpty())
        {
            List<T> res = new ArrayList<>();
            
            for(String pointUrl : pointsUrls)
            {
                T t = null;
                
                if (AutoSalon.class.equals(clazz)) 
                {
                    t = (T) getAutoSalonAndSavePhotos(pointUrl);
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
    
    public static List<AutoSalon> getAutosalonsPoints(List<String> pointsUrls)
    {
        return getPoints(AutoSalon.class, pointsUrls);
    }
    
    private static AutoSalon getAutoSalonAndSavePhotos(String url)
    {        
        if (url != null){
            Document codeDoc = CommonParseUtils.getDocument(url.contains("http") ? url : (PARSED_SITE_URL + url));
            if (codeDoc != null)
            {         
                Elements elements;
                Element element;
                
                element = codeDoc.getElementById("js-point-name");
                String name = element != null ? element.html() : null;
                
                if (name != null && !name.isEmpty()){
                    AutoSalon res = new AutoSalon();
                    
                    setAutosalonSalesChain(element, res);                                        
                    
                    res.setOfficial(name.contains("official"));
                    
                    int tagIndex = name.indexOf('<');
                    
                    name = name.substring(0, tagIndex != -1 ? tagIndex : name.length()).trim();                                                            
                    res.setName(name);
                    
                    res.setNameEn(Transliterator.transliterate(name)
                            .replaceAll("&laquo;", "")
                            .replaceAll("&raquo;", "")
                            .replaceAll("\\.", "")
                            .replaceAll("&quot;", "")
                            .replaceAll("\\)", "")
                            .replaceAll("\\(", "")
                            .replaceAll("\\+", "")
                            .replaceAll("-", "_")
                            .replaceAll(";", "")
                            .replaceAll("№", "")
                            .replaceAll(" ", ""));    
                    
                    Address address = parseAddress(codeDoc);
                    
                    if (address != null){
                        res.setAddress(address);                        
                        
                        setAutosalonSite(codeDoc, res);          
                        
                        setAutosalonWorkHours(codeDoc, res);
                        
                        setAutosalonDescription(codeDoc, res);
                        
                        setAutosalonBrandsIds(codeDoc, res);
                        
                        setAutosalonServices(codeDoc, res);
                        
                        setPhotoCountAndSavePhotos(codeDoc, res);
                        
                        return res;
                    }
                }
            }
        }
        return null;
    }
    
    private static Address parseAddress(Document codeDoc)
    {
        if (codeDoc != null){
            String html = codeDoc.html();
            
            Pattern longitudePattern = Pattern.compile("(var POINT_LON = )(.*)(;)");
            Pattern latitudePattern = Pattern.compile("(var POINT_LAT = )(.*)(;)");

            Matcher matcherFull = longitudePattern.matcher(html);

            if (matcherFull.find()) {
                String longitude = matcherFull.groupCount() == 3 ? matcherFull.group(2).trim() : null;
                if (longitude != null && !longitude.isEmpty()){
                    matcherFull = latitudePattern.matcher(html);

                    if (matcherFull.find()) {
                        String latitude = matcherFull.groupCount() == 3 ? matcherFull.group(2).trim() : null;

                        if (latitude != null && !latitude.isEmpty()){
                            String city = getItemProperty(codeDoc, "addressRegion");
                            String streetAddress = getItemProperty(codeDoc, "streetAddress");
                            String district = getItemProperty(codeDoc, "addressLocality");
                            
                            if (city != null && !city.isEmpty() && streetAddress != null && !streetAddress.isEmpty()){
                                Address address = new Address();
                                
                                address.setCityName(city);
                                address.setAddress(streetAddress);
                                address.setDistrict(district);
                                
                                address.setLatitude(latitude);
                                address.setLongitude(longitude);
                                
                                String phones = getItemProperty(codeDoc, "telephone");
                                                                
                                String[] splittedPhones = phones != null ? phones.split("\\d\\s\\(") : null;
                                                                                               
                                if (splittedPhones != null){                                    
                                    for(int i = 0; i < splittedPhones.length; i++){
                                        splittedPhones[i] = splittedPhones[i].replace('(', '\0').replace(')', '\0').trim();                                        
                                    }
                                    
                                    address.setPhones(new ArrayList(Arrays.asList(splittedPhones)));
                                }
                                
                                return address;
                            }
                        }
                    }
                }
            }
        }
        
        return null;
    }
    
    private static String getItemProperty(Document codeDoc, String autoUaNetPropName){
        Elements elements = codeDoc.getElementsByAttributeValue("itemprop", autoUaNetPropName);
        return (elements != null && !elements.isEmpty()) ? elements.get(0).html() : null;        
    }

    private static void setAutosalonSite(Document codeDoc, AutoSalon res) {
        if (codeDoc != null && res != null){
            Element element = codeDoc.getElementById("homepage");
            if(element != null){
                String siteUrl = element.attr("href");
                                                
                res.setSiteUrl(siteUrl != null ? siteUrl.replace("http://autoua.net/goto/?url=","") : null);

                Elements elements = element.getElementsByTag("span");

                String siteUrlPresentation = (elements != null && !elements.isEmpty()) ? elements.get(0).html() : null;

                res.setSitePresentation(siteUrlPresentation);                                                                                                                
            }
        }
    }

    private static void setAutosalonWorkHours(Document codeDoc, AutoSalon res) {
        if (codeDoc != null && res != null){
            Elements elements = codeDoc.getElementsByClass("e-schedule-fullist");

            String notSplittedSchedule = (elements != null && !elements.isEmpty()) ? elements.html() : null;

            if (notSplittedSchedule != null){
                notSplittedSchedule = notSplittedSchedule.replace("<li>", "").trim();

                String[] splittedShedule = notSplittedSchedule.split("</li>");

                if (splittedShedule != null && splittedShedule.length == 7){

                    processWorkingHour("ПН: ", splittedShedule, 0);
                    processWorkingHour("ВТ: ", splittedShedule, 1);
                    processWorkingHour("СР: ", splittedShedule, 2);
                    processWorkingHour("ЧТ: ", splittedShedule, 3);
                    processWorkingHour("ПТ: ", splittedShedule, 4);
                    processWorkingHour("СБ: ", splittedShedule, 5);
                    processWorkingHour("ВС: ", splittedShedule, 6);
                                      
                    res.setWorkHours(new ArrayList<>(Arrays.asList(splittedShedule)));
                }
            }
        }
    }

    private static void setAutosalonDescription(Document codeDoc, AutoSalon res) {
        if (codeDoc != null && res != null){
            String description = getItemProperty(codeDoc, "description");
                        
            if (description != null && !description.isEmpty()){
                description = description.replace("<a href=\"#\" class=\"open in-hide-down\">Скрыть</a>", "")
                                         .replaceAll("<(.|\\n)*?>", "")
                                         .replaceAll("  ", " ")
                                         .replaceAll("Показать полностью", "")
//                                         
//                                         .replace("</span><br>", "")
//                                         .replace("<span class=\"in-hide\">", "")
                                         .trim();
                                                
                res.setDescription(description);
            }
        }
    }

    private static void setAutosalonBrandsIds(Document codeDoc, AutoSalon autoSalon) {
        if (codeDoc != null && autoSalon != null){
            Elements elements = codeDoc.select("ul.e-brands-content");
            Elements imgs = elements != null ? elements.select("img[title]") : null;
            if (imgs != null && !imgs.isEmpty()){
                List<Integer> res = new ArrayList<>();
                
                for(Element img : imgs){
                    Integer id = CommonParseUtils.selectByName(AutoBrand.MAP, img != null ? img.attr("title") : null);
                    if (id != null){
                        res.add(id);
                    }
                }
                
                autoSalon.setBrandsIds(!res.isEmpty() ? res : null);
            }
        }                
    }

    private static void processWorkingHour(String dayName, String[] splittedShedule, int i) {
        if (splittedShedule != null && i >= 0 && i < splittedShedule.length){
            String workHour;
                    
            workHour = splittedShedule[i];
            if (workHour != null){
                workHour = dayName + workHour.replace('\n', '\0');
                splittedShedule[i] = workHour.trim();
            }
        }
    }

    private static void setAutosalonSalesChain(Element element, AutoSalon autoSalon) {
        if (element != null && autoSalon != null){            
            Elements elements = element.select("img[alt]");
            if (elements != null && !elements.isEmpty()){
                
                List<Integer> res = new ArrayList<>();
                
                for(Element img : elements){
                    Integer id = CommonParseUtils.selectByName(SalesChain.MAP, img != null ? img.attr("alt") : null);
                    if (id != null){
                        res.add(id);
                    }
                }
                
                autoSalon.setSalesChainId(!res.isEmpty() ? res.get(0) : null);                
            }
        }
    }

    private static void setAutosalonServices(Document codeDoc, AutoSalon autoSalon) {
        if (codeDoc != null && autoSalon != null){
            Elements elementsOfServices = codeDoc.getElementsByClass("e-contentlist-text");
            if (elementsOfServices != null && !elementsOfServices.isEmpty()){
                List<Integer> res = new ArrayList<>();
                
                for (Element elementOfService : elementsOfServices){
                    Integer id = CommonParseUtils.selectByName(AutoService.MAP, elementOfService != null ? elementOfService.text() : null);
                    if (id != null){                        
                        res.add(id);                                                
                    }
                }
                
                autoSalon.setServicesIds(!res.isEmpty() ? res : null);
            }
        }
    }

    private static void setAutosalonNameEn(Document codeDoc, AutoSalon autoSalon) {
        if (codeDoc != null && autoSalon != null){
            Elements salonLinks = codeDoc.select("a.e-gallery-mainlink");
            
            if (salonLinks != null && !salonLinks.isEmpty()){
                String hrefImg = salonLinks.get(0).attr("href");
                
                if (hrefImg != null){
                    autoSalon.setNameEn(hrefImg.replace("/media/photos/", "").replace('/', '\0').replaceAll("\\d", "").replace(".jpg", "").replace(".JPG", "").trim());
                }                                
            }
        }
    }

    private static void setPhotoCountAndSavePhotos(Document codeDoc, AutoSalon autoSalon) {
        if (codeDoc != null && autoSalon != null){
            Element gallery = codeDoc.getElementById("e-gallery");                        
            
            Elements aHrefsWithImg = gallery != null ? gallery.select("a[href]") : null;
            if (aHrefsWithImg != null && !aHrefsWithImg.isEmpty()){
                List<String> photoUrls = new ArrayList<>();
                
                for (Element img : aHrefsWithImg){
                    String href = img != null ? img.attr("href") : null;
                    
                    if (href != null && href.length() > 4 && href.substring(href.length() - 4, href.length()).equalsIgnoreCase(".jpg")){
                        photoUrls.add(PARSED_SITE_URL + href);
                    }
                }
                
                String autosalonNameEn = autoSalon.getNameEn();
                
                if (autosalonNameEn != null && !autosalonNameEn.isEmpty()){                
                    
                    String photoFilePathStart = //File.separator + autosalonNameEn +File.separator;
                                                "autosalonPhoto" + File.separator + autosalonNameEn + File.separator;
                    
                    int currentImgNumber = 0;
                    

                    for (String url : photoUrls){                        
                        String path = photoFilePathStart + currentImgNumber + ".jpg";                                                                                                
                        
                        if (FileUtils.saveImage(url, path)){
                            currentImgNumber++;
                        }
                    }

                    autoSalon.setPhotoCount(currentImgNumber);
                }
                else{
                    String name = autoSalon.getName();
                    
                    LOGGER.error("Can't save autosalon photos, en name is null! Russian name: " + (name != null ? name : "null"));
                }
            }
        }
    }
    
}
