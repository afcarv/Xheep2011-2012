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
		   void seleccionaEquipa()
		   {
			   //Variáveis para records:
			   int cem=0,quat=0,oit=0,alt=0,comp=0,cemi=0,quati=0,oiti=0,alti=0,compi=0;
			   for(int i=0;i<sa.size();i++)
			   {
				   if(sa.get(i).getDist==100 && sa.get(i).getCem<cem)
				   {
					   cem=sa.get(i).getCem;
					   cemi=sa.get(i);
				   }
				   else if(sa.get(i).getDist==400 && sa.get(i).getQuat<quat)
				   {
					   quat=sa.get(i).getQuat;
					   quati=sa.get(i);
				   }
				   else(sa.get(i).getDist==800 && sa.get(i).getOit<oit)
				   {
					   oit=sa.get(i).getOit;
					   oiti=sa.get(i);
				   }
			   }
			   for(int i=0;i<co.size();i++)
			   {
				   if(co.get(i).getModalidade.equals("Altura") && co.get(i).getAlt>alt)
				   {
					   alt=co.get(i).getAlt;
					   alti=co.get(i);
				   }
				   else if(co.get(i).getModalidade.equals("Comprimento") && co.get(i).getComp<comp)
				   {
					   comp=co.get(i).getComp;
					   compi=co.get(i);
				   }
		   }

}
