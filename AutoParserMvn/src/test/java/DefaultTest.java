/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import com.ukrautoportal.autouaparser.data.Address;
import com.ukrautoportal.autouaparser.data.AutoSalon;
import com.ukrautoportal.autouaparser.data.Phone;
import com.ukrautoportal.autouaparser.utils.ParseUtils;
import com.ukrautoportal.parser.utils.CommonParseUtils;
import com.ukrautoportal.utils.FileUtils;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import org.junit.After;
import org.junit.AfterClass;
import static org.junit.Assert.*;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;

/**
 *
 * @author swat
 */
public class DefaultTest {
    
    public DefaultTest() {
    }
    
    @BeforeClass
    public static void setUpClass() {
    }
    
    @AfterClass
    public static void tearDownClass() {
    }
    
    @Before
    public void setUp() {
    }
    
    @After
    public void tearDown() {
    }

    // TODO add test methods here.
    // The methods must be annotated with annotation @Test. For example:
    //
     @Test
     public void defTest()
     {
         try{
 
		   FileInputStream fin = new FileInputStream("autosalons.ser");
		   ObjectInputStream ois = new ObjectInputStream(fin);
		   List<AutoSalon> res = (List<AutoSalon>) ois.readObject();
		   ois.close();
 
                   for (AutoSalon autoSalon : res){
                       String url = autoSalon.getSiteUrl();
                       
                       autoSalon.setSiteUrl(url != null ? url.replace("http://autoua.net/goto/?url=","") : null);
                       
                       List<String> workHours = autoSalon.getWorkHours();
                       if (workHours != null && !workHours.isEmpty()){
                           String workHour;
                    
                            workHour = workHours.get(0);
                            if (workHour != null){
                                workHour = "ПН: " + workHour.replace('\n', '\0');
                                workHours.set(0, workHour.trim());
                            }
                       }
                   }
                   
                   
                FileOutputStream fout = new FileOutputStream("autosalons2.ser");
                ObjectOutputStream oos = new ObjectOutputStream(fout);
                oos.writeObject(res);
 
	   }catch(Exception ex){
		   ex.printStackTrace();
	   } 
         
         
//        List<String> autosalonsUrls = FileUtils.readStringsFromFile(new File("autosalonsURLs.list"));
        
        

//        List<AutoSalon> res = ParseUtils.getAutosalonsPoints(autosalonsUrls);
      
//        List<AutoSalon> res = new ArrayList<>();
//        
//        AutoSalon autoSalon = new AutoSalon();
//        
//        Address a = new Address();
//        
//        Phone p1 = new Phone();
//        p1.setPhoneNumber("sdfsdf 22");
//        p1.setDescription("sdaf");
//        
//        Phone p2 = new Phone();
//        p2.setPhoneNumber("sdfsdf 22");
//        p2.setDescription("sdaf");
//        
//        a.setPhones(new ArrayList<>(Arrays.asList(new Phone[]{p1, p2})));                
//        
//        autoSalon.setAddress(a);
//        
//        res.add(autoSalon);
//        res.add(autoSalon);
//        try
//        {
//            FileOutputStream fout = new FileOutputStream("autosalons.ser");
//            ObjectOutputStream oos = new ObjectOutputStream(fout);
//            oos.writeObject(res);
//        }
//        catch (IOException ioe){
//            ioe.printStackTrace();
//        }
//        String jsonString = CommonParseUtils.toJSONString(res);
//        
//        FileUtils.saveStringToFile(, jsonString);
         
         
//         List<String> autosalonsUrls = ParseUtils.getPointUrls("http://point.autoua.net/avtosalony/vse/ukraina/?page=", 39);
//         
//         if(autosalonsUrls != null && !autosalonsUrls.isEmpty()){
//             for(int i = 0; i < autosalonsUrls.size(); i++){                 
//                 autosalonsUrls.set(i, ParseUtils.PARSED_SITE_URL + autosalonsUrls.get(i));
//             }
//         }
         
//         FileUtils.saveStringListToFile("autosalonsURLs.list", autosalonsUrls);
//         List<AutoSalon> res = ParseUtils.getAutosalonsPoints(39);
         
//         res.size();
//         assertNotNull(res);
     }
}
