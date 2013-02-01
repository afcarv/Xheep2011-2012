package Exame2;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;
import common.FicheiroDeTexto;



public class Banda 
{
	// m"n": músicos da banda "n" 
	ArrayList <Musicos> mu = new ArrayList<Musicos>();
	ArrayList <Musicos> mu2 = new ArrayList<Musicos>();
	ArrayList <Musicos> mu3 = new ArrayList<Musicos>();
	
	//exercício 2:
	void exportMusicos(String fileName) 
	{
		//novo objecto do tipo ficheiro de texto:
		FicheiroDeTexto ficheiroDeTexto=new FicheiroDeTexto();

		File fileName1 = new File ("musicos.txt");

		try {
			ficheiroDeTexto.abreEscrita(fileName1);
		} catch (IOException ex) {
			Logger.getLogger(Musicos.class.getName()).log(Level.SEVERE, null, ex);
		}
		//percorre array com todos os músicos:
		for(int i=0;i<mu.size();i++) 
		{
			//Cria objecto do tipo músico para instanciar o músico actual:
			Musicos musicos = mu.get(i).getNome(); 
			try 
			{
				ficheiroDeTexto.escreverLinha(musicos.getNome() + " " + musicos.getTipo() + " " + musicos.getInstrumento);
			} catch (IOException ex) 
			{
				Logger.getLogger(Musicos.class.getName()).log(Level.SEVERE, null, ex);
			}
		}
	}
	//Exercício 3:
	void uneBandas(){
		
		int maestro1=0;
		int maestro2=0;
		
		//percorre banda 1 para adicionar "não maestros":
		for(int i=0;i<mu.size();i++)
		{
			//definir com nome actual:
			Musicos mus = mu.get(i).getNome();
			if(mus.getTipo().equals("Maesttro")==false)
			{
				mu3.add(mus);
			}
			else
			{
				//Caos seja um maestro, guarda o ano de formação:
				maestro1=mus.get(i).getAno();
			}
		}
		for(int i=0;i<mu2.size();i++)
		{
			//objecto músico para adicionar caso não seja maestro: 
			Musicos mus2 = mu2.get(i).getNome();
			if(mus2.getTipo().equals("Maestro")==false)
			{
				mu3.add(mus2);
			}
			//Caos seja um maestro, guarda o ano de formação:
			else
			{
				maestro2=mus2.get(i).getAno();
			}
		}
		//percorre músicos da banda 1 para encontrar o maestro:
		for(int i=0;i<mu.size();i++)
		{
			Musicos mt1 = mu.get(i); 
			//Quando encontra adiciona caso tenha mais anos de formação:
			if(mt1.getTipo().equals("Maestro") && maestro1>maestro2)
			{
				mu3.add(mt1);
			}
		}
		//percorre músicos da banda 2 para encontrar o maestro:
		for(int i=0;i<mu2.size();i++)
		{
			Musicos mt2 = mu2.get(i); 
			//Quando encontra adiciona caso tenha mais anos de formação:
			if(mt2.getTipo().equals("Maestro") && maestro2>maestro1)
			{
				mu3.add(mt2);
			}
		}
	}
}

