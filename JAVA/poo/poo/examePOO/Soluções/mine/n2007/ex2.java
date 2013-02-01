package Exame1;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

import common.FicheiroDeTexto;

public class Equipa 
{
		ArrayList<Atleta> at = new ArrayList<Atleta>();
		ArrayList<Salto> sa = new ArrayList<Salto>();
		ArrayList<Corrida> co = new ArrayList<Corrida>();
		
		   void exportAtrasados(String fileName) {
		    	//novo objecto do tipo ficheiro de texto:
		        FicheiroDeTexto ficheiroDeTexto=new FicheiroDeTexto();
		        
		        File fileName = new File ("medalhados.txt");
		        
		        try {
		            ficheiroDeTexto.abreEscrita(fileName);
		        } catch (IOException ex) {
		            Logger.getLogger(Equipa.class.getName()).log(Level.SEVERE, null, ex);
		        }

		        for(int i=0;i<at.size();i++) {
		        	if(at.get(i).getMedalhasBronze>=1||at.get(i).getMedalhasPrata>=1||at.get(i).getMedalhasOuro>=1)
		                try {
		                ficheiroDeTexto.escreverLinha(Atleta.getNome() + " " + Atleta.getTipo() + " " + Atleta.getMedalhasOuro+ " " + Atleta.getMedalhasPrata+ " " + Atleta.getMedalhasBronze);
		            } catch (IOException ex) {
		                Logger.getLogger(Equipa.class.getName()).log(Level.SEVERE, null, ex);
		            }
		        }
		    }

}
