/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;
import java.nio.channels.Channels;
import java.nio.channels.ReadableByteChannel; 
import java.util.ArrayList; 
import java.util.HashMap; 
import java.util.List; 
import junit.framework.TestCase;
import redstone.xmlrpc.XmlRpcClient;
import redstone.xmlrpc.XmlRpcException;
import redstone.xmlrpc.XmlRpcFault;


/**
 *
 * @author swat
 */
public class NonRunTest extends TestCase {

    public NonRunTest(String testName) {
        super(testName);
    }

    @Override
    protected void setUp() throws Exception {
        super.setUp();
    }

    @Override
    protected void tearDown() throws Exception {
        super.tearDown();
    }

    public void testDefaultPost() throws MalformedURLException, XmlRpcException, IOException {
         // the url of your xmlrpc.php, typically
        // of the form http://your.domain.here/wordpress/xmlrpc.php
        String xmlRpcUrl = "http://ukrautoportal.com/xmlrpc.php";
        // this key is not used in my wordpress version
        String apiKey = "60ce0324e2c4";
        String userName = "localhost";
        String password = "181192";
        // in my wordpress version the blogId is "1"
        String blogId = "1";

//        XmlRpcClientConfigImpl config = new XmlRpcClientConfigImpl();
//        config.setServerURL(new URL(xmlRpcUrl));
//
//        XmlRpcClient client = new XmlRpcClient();
//        client.setConfig(config);
//
//        BlogInfo blogInfo = new BlogInfo(apiKey, userName, password, blogId);
//
//        BlogPoster poster = new BlogPoster(client, blogInfo);
//        poster.setPostType(PostType.draft);
////        poster.post(contents());
//        
//        
//        
//        Object post = poster.get(98);
//        post.getClass();                
 
        try {
            //First step, init an client
            XmlRpcClient client = new XmlRpcClient(xmlRpcUrl, true);
            //Now, put data into the client. The client will encode all data into XML and send it to wordpress XML-RPC API
            HashMap hmContent = new HashMap();
            hmContent.put("title", "TestPage3 <div style=\"float: right; display: inline-flex; background-color: #FFCC00; padding: 0 10px 0 10px; font-weight: 100; font-size: 18px; letter-spacing: 0.1px;\">Официальный</div>");
            hmContent.put("description", "<script type='text/javascript' src='http://ukrautoportal.com/wp-content/themes/blockmagazine/js/jquery.flexslider.start.single.js?ver=3.9.2'></script><div id=\"type\" style=\"display: none;\">autosalon</div>"
                    + "<div id=\"d\" style=\"display: none;\">50.387510</div>\n" +
"<div id=\"e\" style=\"display: none;\">30.882076</div>\n" +
"<div id=\"cst_zoom\" style=\"display: none;\">16</div>\n" +

                    "<div style=\"width: 45%; height: 226px; float: left; margin: 6px; margin-right: 18px;\"><div class=\"flexslider singleslider\" >\n" +
"<div class=\"tmnf_slideshow_menu\">	<div class=\"slideshow_nav\">\n" +
"	<ul class=\"flex-direction-nav\">\n" +
"	<li>\n" +
"		<a href=\"#\" class=\"prev\" title=\"Previous\">Previous</a>\n" +
"	</li>\n" +
"	<li>\n" +
"		<a href=\"#\" class=\"next\" title=\"Next\">Next</a>\n" +
"	</li>\n" +
"	</ul>\n" +
"	</div>\n" +
"</div><div class=\"clear\"></div>\n" +
"<ul class=\"slides\">\n" +
"	<li class=\"flex-active-slide\" style=\"width: 100%; float: left; margin-right: -100%; position: relative; display: list-item;\">\n" +
"		<img src=\"http://ukrautoportal.com/wp-content/uploads/2014/08/2014-ram-1500-diesel-021-1.jpg\" class=\"attachment-gallery-slider\"> </li>\n" +
"	<li class=\"\" style=\"width: 100%; float: left; margin-right: -100%; position: relative; display: none;\">\n" +
"		<img src=\"http://ukrautoportal.com/wp-content/uploads/2014/08/2014-ram-1500-diesel-020-1.jpg\" class=\"attachment-gallery-slider\"> </li>\n" +
"	<li class=\"\" style=\"width: 100%; float: left; margin-right: -100%; position: relative; display: none;\">\n" +
"		<img src=\"http://ukrautoportal.com/wp-content/uploads/2014/08/2014-ram-1500-diesel-016-1.jpg\" class=\"attachment-gallery-slider\"> </li>\n" +
"</ul><!-- .slides --><div class=\"clearfix\"></div><div id=\"slideshowloader\"></div><ul class=\"flex-direction-nav\"><li><a class=\"flex-prev\" href=\"#\">Previous</a></li><li><a class=\"flex-next\" href=\"#\">Next</a></li></ul></div>"
+ "<div style=\"padding-top: 15px;\"><div style=\"float: left; padding: 5px;\">Бренды:</div><img src=\"http://ukrautoportal.com/wp-content/uploads/auto-brands/1.jpg\" style=\"height: 30px\"><img src=\"http://ukrautoportal.com/wp-content/uploads/auto-brands/2.jpg\" style=\"height: 30px\"></div>" +
"</div>"+
"[wpgmza id=\"1\"]\n" +
"<div class=\"l-middle-left\">\n" +
"«Порше Центр Київ Аеропорт» - найбільший в Україні та у Центральній та Східній Європі офіційний дилерський центр Porsche, який надає повний комплекс послуг з продажу автомобілів Porsche, оригінальних запчастин та аксесуарів, а також сервісного обслуговування та ремонту. \n" +
"\n" +
"«Порше Центр Київ Аеропорт» входить до еліти флагманських дилерів Porsche Exclusive та Porsche Driver`s Selection у світі та є єдиним в Україні флагманським дилером, пропонуючи широкий асортимент рішень для індивідуалізації автомобілів Porsche за допомогою дизайнерського і технічного тюнингу кузова та салону - від окремих змін до комплексних модифікацій для задоволення персональних вподобань кожного клієнта. \n" +
"Для реалізації сервісної підтримки клієнтів діє сучасний сервісний центр з обслуговування автомобілів Porsche. Нове сервісне обладнання, 13 підйомників станції технічного обслуговування, серед яких - 2 діагностичних пости та пост регулювання розвалу-сходження, власний склад запасних частин, висококваліфікований персонал, який проходить на регулярній основі технічне навчання за програмами Porsche AG, у поєднанні з індивідуальним підходом і уважним ставленням до вимог клієнта дозволяють виконувати гарантійний ремонт, технічне обслуговування та будь-які інші види робіт відповідно до високих критеріїв якості Porsche у найкоротші строки і з максимальною зручністю для кожного клієнта. Щодня дилерський центр готовий обслужити щонайменше 26 автомобілів Porsche будь-якої моделі та року випуску. \n" +
"\n" +
"«Порше Центр Київ Аеропорт» - прагнення завжди надавати кращий сервіс через легендарні автомобілі кожного дня кожному клієнту, відкриваючи приголомшливий світ нових можливостей від Porsche. \n" +
"Чекаємо на Вас у «Порше Центр Київ Аеропорт»!\n" +
"</div>\n" +
"<div class=\"l-middle-right\">\n" +
"<div class=\"b-shortaddress\">\n" +
"<div class=\"e-shortaddress-item\">\n" +
"<div class=\"e-shortaddress-label\">Город:</div>\n" +
"<div>Киев, с. Чубинское</div>\n" +
"</div>\n" +
"<div class=\"e-shortaddress-item\">\n" +
"<div class=\"e-shortaddress-label\">Адрес:</div>\n" +
"<div id=\"js-point-address\"> ул. Киевская, 43, 32 км Бориспольского шоссе</div>\n" +
"</div>\n" +
"<div class=\"e-shortaddress-item\">\n" +
"<div class=\"e-shortaddress-label\">E-mail:</div>\n" +
"<div class=\"e-phone-block\"><a title=\"pcka@winner.ua\" href=\"mailto:pcka@winner.ua\">pcka@winner.ua</a></div>\n" +
"</div>\n" +
"<div class=\"e-shortaddress-item\">\n" +
"<div class=\"e-shortaddress-label\">Сайт:</div>\n" +
"<div class=\"e-phone-block\">\n" +
"<div class=\"e-phone-block\"><a id=\"homepage\" class=\"out pseudo\" title=\"www.porsche.ua\" href=\"http://www.porsche.ua/dealers/kiev/\" target=\"_blank\">www.porsche.ua</a></div>\n" +
"</div>\n" +
"</div>\n" +
"<div class=\"e-shortaddress-item\">\n" +
"<div class=\"e-shortaddress-label\">График:</div>\n" +
"<div class=\"e-schedule-table__full\">\n" +
"<div><span style=\"color: gray;\">ПН</span> 10:00–21:00</div>\n" +
"<div><span style=\"color: gray;\">ВТ</span> 10:00–21:00</div>\n" +
"<div><span style=\"color: gray;\">СР</span> 10:00–21:00</div>\n" +
"<div><span style=\"color: gray;\">ЧТ</span> 10:00–21:00</div>\n" +
"<div><span style=\"color: gray;\">ПТ</span> 10:00–21:00</div>\n" +
"<div><span style=\"color: gray;\">СБ</span> 10:00–21:00</div>\n" +
"<div><span style=\"color: gray;\">ВС</span> 10:00–21:00</div>\n" +
"</div>\n" +
"</div>\n" +
"</div>\n" +
"</div>");
//            hmContent.put("post_status", "draft");
            //Basically, we can put anything here as long as it match's wordpress's fields.
//            hmContent.put("categories", new String[]{"Автосалоны"});
//            hmContent.put("post_thumbnail", new String[]{"Автосалоны"});
            
            //All set!! Let's roll~ and call the wordpress.
            Object newPostResult = client.invoke("wp.newPage", new Object[] {new Integer(1), userName, password,
                                                                      hmContent,
                                                                      true} );
            if (newPostResult != null)
            {
                System.out.println(newPostResult.toString());                
            }           
            
        } catch (XmlRpcException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } 
        catch (XmlRpcFault e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } 
        catch (MalformedURLException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
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
    
    private static String contents() throws IOException {
    // According to the wordpress post format the title and
    // category id of the post get some special mark up.
    return "<title>Test 5</title> <struct> <member>" +
"<name>categories</name>" +
"<value><array><data><value>map-points</value><value>auto-salons</value></data></array></value>" +
"</member></struct>  ";
  }

    private void saveToFiles(List<String> list){
        
        for(String url : list){
            try{
            URL website = new URL(url);
            ReadableByteChannel rbc = Channels.newChannel(website.openStream());
            FileOutputStream fos = new FileOutputStream(Integer.toString(list.indexOf(url) + 1) + ".jpg");
            fos.getChannel().transferFrom(rbc, 0, Long.MAX_VALUE);
            }
            catch (IOException ignore){
                ignore.printStackTrace();
            }
        }
    }
}
