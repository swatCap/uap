/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.ukrautoportal.utils;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileWriter;
import java.io.IOException;
import java.util.List;
import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

/**
 *
 * @author swat
 */
public class FileUtils {

    private static final Logger LOGGER = LogManager.getLogger(FileUtils.class.getName());    
    
    
    public static void saveStringListToFile(String filename, List<String> list)
    {         
        if (list != null && !list.isEmpty())
        {
            try (FileWriter writer = new FileWriter(filename != null ? filename : "default.txt"))
            {           
                for(String str: list) 
                {
                    writer.write(str);
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
}
