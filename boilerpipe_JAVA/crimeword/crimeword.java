package crimeword;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.net.URL;

import de.l3s.boilerpipe.extractors.ArticleExtractor;

public class crimeword 
{

	public void articleextractor() throws IOException
	{
		//System.out.println("Begins");

	      System.out.println("Begins!!");
		  String csvFile = "C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/headline_crimes.csv";
		  BufferedReader br = null;
		  String line = "";
		  String cvsSplitBy = ",";
		  arraycrime a=new arraycrime();
		  String[] crimearray= a.crimearray();
		  //System.out.println(crimearray[521]);  		 
		 
			   PrintWriter wri = new PrintWriter(new File("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/b.csv") );
			   br = new BufferedReader(new FileReader(csvFile));
			   while ((line = br.readLine()) != null) 
			     {
	                
	                    
			     	    // use comma as separator
				          String[] news = line.split(cvsSplitBy);
	                     
	                            // System.out.println(news[0]);
	                    	   String newsurl=news[1].toLowerCase();
	                    	   System.out.println(newsurl);
	                    	   for(int j=1;j<crimearray.length&&Integer.parseInt(news[0].replaceAll("\"",""))>29040;j++)
	                    	   {   String b=crimearray[j].toLowerCase();
	                    	       String c=b.replaceAll("\"", "");
	                    	        
	                    		   int i =newsurl.indexOf(c);System.out.println(i+news[0]);
	                    	    if (i!=-1)
	                    	      {
			 	                   wri.write(news[0]+','+crimearray[j]+'\n');
			                       break;    
	                    	      }   
			                   }
	 
			                 
	                   
	 
		          }
		   
		 wri.close();br.close();
	 
		 System.out.println("Done");
	 }

	
	public static void main(String[] args) throws IOException
	{
	    crimeword obj= new crimeword();
	    obj.articleextractor();
	}
}
