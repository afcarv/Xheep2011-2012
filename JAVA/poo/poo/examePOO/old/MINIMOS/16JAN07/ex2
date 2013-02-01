package N2007;


import java.io.File;
import java.io.FileFilter;
import java.io.FileWriter;
import java.io.IOException;
import java.io.OutputStreamWriter;

public class Equipa {
	public static void main(String[]args){
	File f1 = new File("mostraMedalhas.txt");
	FileFilter out;
	
	try{
		out=(FileFilter) new FileWriter(f1);
		
		Atleta tab[] = new Atleta[n];
		
		
		int c;
		for(int i=0;i<tab.lenth;i++){
			if(tab[i].medalhaOuro>0 ||tab[i].medalhaPrata>0||tab[i].medalhaBronze>0){
				out.write(tab[i]);
			}
			       
			       
			       
			       
		((OutputStreamWriter) out).close();
	}
	catch(IOException e){
		System.out.println("Erro");
	}
	
	}
}