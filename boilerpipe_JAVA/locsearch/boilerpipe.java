package locsearch;

import de.l3s.boilerpipe.BoilerpipeProcessingException;
import de.l3s.boilerpipe.extractors.ArticleExtractor;

import java.net.MalformedURLException;
import java.net.URL;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.io.Writer;



public class boilerpipe 
{

	public static void main(String[] args) throws MalformedURLException, BoilerpipeProcessingException 
	{
		 System.out.println("Begins!!");
 		  String csvFile = "C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/Final Url-0.csv";
 		  BufferedReader br = null;
 		  String line = "";
 		  String cvsSplitBy = ",";
 		  locationarray a=new locationarray();
  		  String[] locarray= a.locarray();
  		  String place="";
  		
 	
 		  try 
 		    {
 			   BufferedWriter wri = new BufferedWriter(new FileWriter("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/loc.csv") );
 			   br = new BufferedReader(new FileReader(csvFile));
 			   while ((line = br.readLine()) != null) 
 			     {
 	                if (line.length()>0 )
 	                   { 
 			     	    // use comma as separator
 				          String[] news = line.split(cvsSplitBy);
 	                      
 	                             
 	                    	     String newsurl=news[1];
 	                    		 try
 	                    		 {
 	                    	      
 	                    	      URL url = new URL(newsurl);
 			                      String text = ArticleExtractor.INSTANCE.getText(url);  
 	                    		 
 			                        
 			                	   for (int i=0;i<locarray.length;i++)
 			       	                   {     place=locarray[i];
 			                                 int j=text.indexOf(place);
 					                         if (j>=0) 
 					                            {
 			 			                        wri.write(news[0]+","+newsurl+','+place+'\n');
 			 			                        wri.flush();
 					                        	System.out.print(newsurl+','+place);
 			 			                        System.out.println(news[0]);
 			                                      break;
 			                                    }
 			                 	       }
 	                    		 }
 			                     catch(Exception e)
 			                     {
 			                    	 continue;
 			                     }
 	                      }
 	             }
 	 
 		          
 		  }	   
 		  catch (Exception e) 
 		  {
 			 e.printStackTrace();
 		  } 
 		
 		  finally  
 		  {
 			 if (br != null) 
 			    {
 				   try 
 				     {
 					 br.close();
 					 } 
 				   catch (IOException e) 
 				     {
 					 e.printStackTrace();
 				     }
 			    }
 		  }
 	 
 		 System.out.println("Done");
 	 }
	}

