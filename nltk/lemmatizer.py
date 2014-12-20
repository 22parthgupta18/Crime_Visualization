# -*- coding: utf-8 -*-
"""
Created on Thu Dec 18 11:13:26 2014

@author: rajas
"""
from nltk.stem.lancaster import LancasterStemmer
#code for making lemma file...
def lemmatizer_crime() :
     
  lancaster_stemmer = LancasterStemmer()
  fw=open("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/lemma.csv","w")
  fr=open("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/crime.csv","rU")
  for line in fr:
    crimelist=line.split(",")
    crimewords=(crimelist[1].replace("\"","")).strip()
    crimelemma=lancaster_stemmer.stem(crimewords) 
    fw.write(crimelist[0]+","+"\""+crimelemma+"\""+"\n")
  fw.close()
  fr.close()  

#code for reading headlines using lemmatizer
def lemmatizer_newsheadlines() :
    lancaster_stemmer = LancasterStemmer()
    frl=open("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/lemma1.csv","rU")
    fr=open("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/sample.csv","rU")
    fw=open("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/lemmaheadlines.csv","w")
    for headline in fr:
        if len(headline)>0:
          headlinelist=headline.split(",")
        
          if len(headlinelist)==3:
            headlinewords=headlinelist[1].split(" ")
            print(headlinewords)
            for word in headlinewords:
              wordcor=(((word.replace("?","")).replace(":","")).replace("\"",""))    
               
              headlineword=(lancaster_stemmer.stem(wordcor)).lower()
              print(headlineword) 
     #         for line in frl:
      #          crimelist=line.split(",")
       #         crimeword=((crimelist[1].replace("\"","")).strip()).lower()
               
        #        print(crimeword+str(i))
         #       i+=1
              dictcrime=lemmadict()
              if headlineword in dictcrime:
                  print(headlineword+"yipee")
                  fw.write(headlineword+","+headlinelist[0]+","+headlinelist[1]+"\n")
                                    
                  break;
    frl.close()     
    fw.close()
    fr.close()
     
    
lemmatizer_newsheadlines()
#code to make dict of lemma words 
def lemmadict():
     lemma_dict=[] 
     frl=open("C:/Users/rajas/Downloads/csv_files-2014-12-10/csv files/lemma1.csv","rU")
     for line in frl:
         crimelist=line.split(",")
         crimeword=((crimelist[1].replace("\"","")).strip()).lower()
         lemma_dict.append(crimeword)
     return lemma_dict[:]
    