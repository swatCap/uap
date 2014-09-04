/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.ukrautoportal.utils;

import com.ukrautoportal.parser.utils.CommonParseUtils;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;
import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

/**
 *
 * @author swat
 */
public class FileUtils {

    private static final Logger LOGGER = LogManager.getLogger(FileUtils.class.getName());    
    
    
    public static void saveStringToFile(String filename, String string)
    {                 
        try (FileWriter writer = new FileWriter(filename != null ? filename : "default.txt"))
        {                           
            writer.write(string != null ? string : "");                                    
        } 
        catch (IOException ex) 
        {
            LOGGER.error("Error saving string data to file", ex);
        }
    }
    
    public static void saveStringListToFile(String filename, List<String> list)
    {         
        if (list != null && !list.isEmpty())
        {
            try (FileWriter writer = new FileWriter(filename != null ? filename : "default.txt"))
            {           
                for(String str: list) 
                {
                    writer.write((str != null ? str : "") + "\n");                    
                }
            } 
            catch (IOException ex) 
            {
                LOGGER.error("Error saving strings data to file", ex);
            }
        }
    }
    
    
    public static byte[] getBytesFromFile(String path) throws IOException
    {
        File file = new File(path);
        byte[] fileData = new byte[(int) file.length()];
        try (FileInputStream in = new FileInputStream(file)) {
            in.read(fileData);
        }
        
        return fileData;
    }
    
    
    public static List<String> readStringsFromFile(File fin){
        if (fin != null) {
            try {
                FileInputStream fis = new FileInputStream(fin);

                try (BufferedReader br = new BufferedReader(new InputStreamReader(fis))){

                    List<String> res = new ArrayList<>();
                    
                    String line;
                    while ((line = br.readLine()) != null) {
                        res.add(line);
                    }

                    return !res.isEmpty() ? res : Collections.EMPTY_LIST;
                } catch (IOException ioe) {
                    LOGGER.error("[ERROR] Can't read file ", ioe);
                }
            } catch (FileNotFoundException fnfe){
                LOGGER.error("[ERROR] Can't read file - file not found ", fnfe);
            }
        }
        else{
            LOGGER.error("[ERROR] Can't read file - file is null");
        }
        
        
        return null;
    }
    
    public static boolean saveImage(String imageUrl, String destinationFile)  {
        if (imageUrl != null) {                       
            
            if (createFile(destinationFile)){            
                try{
                    URL url = new URL(imageUrl);

                    try (InputStream is = url.openStream()){                        
                        try(OutputStream os = new FileOutputStream(destinationFile)){

                            byte[] b = new byte[2048];
                            int length;

                            while ((length = is.read(b)) != -1) {
                                    os.write(b, 0, length);
                            }

                            return true;
                        }
                    }
                    catch (IOException iOException){
                        LOGGER.error("[ERROR] Can't save img: " + imageUrl, iOException);
                    }
                }
                catch (MalformedURLException exception){
                    LOGGER.error("[ERROR] Can't save img: " + imageUrl, exception);
                }
            }
        } else {
            LOGGER.error("[ERROR] Can't save img: null URL");
        }        
        return false;
    }
    
    
    public static boolean createFile(String path){
        if (path != null && !path.isEmpty()){
            File f = new File(path);

            f.getParentFile().mkdirs();
            
            if (!f.exists()){
                try {
                    f.createNewFile();                
                }
                catch (IOException ioe){
                    LOGGER.error("[ERROR] Can't create file " + path, ioe);

                    return false;
                }
            }

            return true;
        } else{
            LOGGER.error("[ERROR] Can't create file: null path");
            return false;
        }
    }
    
    
}
