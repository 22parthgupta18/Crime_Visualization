package articleextractor;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileReader;
import java.io.FileWriter;
import java.net.URL;

import de.l3s.boilerpipe.extractors.ArticleExtractor;

public class Article 
{

	public void articleextractor()
	{
		System.out.println("Begins");
		
		try
		  { String line="";
		    BufferedWriter wri= new BufferedWriter(new FileWriter("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/Articles.csv"));
		    BufferedReader br= new BufferedReader(new FileReader("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/loc.csv"));
		    while((line=br.readLine())!=null)
		    {  
		    	try
		    	{	
		    		if(line.length()>0)
		    	      {
		    		    String[] news=line.split(",");
		    		    System.out.println(news[0]);
		    		    URL url=new URL(news[1]);
		    		    String text = ArticleExtractor.INSTANCE.getText(url);
		    		    wri.write(news[0]+","+text+"\n");
		    	      }
		    	 }
		    	 catch(Exception e)
		    	 {
		           continue;
		    	 }
		    }
		
		  }		
	     catch(Exception e)
		{
	    	 e.printStackTrace();
		}
		
	}
	
	public static void main(String[] args)
	{
	    Article obj= new Article();
	    obj.articleextractor();
	}
}
