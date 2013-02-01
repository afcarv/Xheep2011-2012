package Exame1;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

import common.FicheiroDeTexto;
import exameperguntac.Leitor;

public class Equipa 
{
	ArrayList<Atleta> at = new ArrayList<Atleta>();
	ArrayList<Salto> sa = new ArrayList<Salto>();
	ArrayList<Corrida> co = new ArrayList<Corrida>();
	ArrayList<Atleta> sel = new ArrayList<Atleta>();

	//exercício 2:
	void exportMedalhados(String fileName) {
		//novo objecto do tipo ficheiro de texto:
		FicheiroDeTexto ficheiroDeTexto=new FicheiroDeTexto();

		File fileName1 = new File ("medalhados.txt");

		try {
			ficheiroDeTexto.abreEscrita(fileName1);
		} catch (IOException ex) {
			Logger.getLogger(Equipa.class.getName()).log(Level.SEVERE, null, ex);
		}
		//procura atletas com pelo menos uma medalha:
		for(int i=0;i<at.size();i++) {
			Atleta atleta = at.get(i).getNome;
			if(at.get(i).getMedalhasBronze>=1||at.get(i).getMedalhasPrata>=1||at.get(i).getMedalhasOuro>=1)
				try {
					ficheiroDeTexto.escreverLinha(atleta.getNome() + " " + atleta.getTipo() + " " + atleta.getMedalhasOuro+ " " + atleta.getMedalhasPrata+ " " + atleta.getMedalhasBronze);
				} catch (IOException ex) {
					Logger.getLogger(Equipa.class.getName()).log(Level.SEVERE, null, ex);
				}
		}
	}
	//exercício 3:
	void seleccionaEquipa()
	{
		//Variáveis para records:
		int cem=0,quat=0,oit=0,alt=0,comp=0,cemi=0,quati=0,oiti=0,alti=0,compi=0;
		for(int i=0;i<sa.size();i++)
		{
			if(sa.get(i).getDist==100 && sa.get(i).getCem<cem)
			{
				cem=sa.get(i).getCem;
				cemi=i;
			}
			else if(sa.get(i).getDist==400 && sa.get(i).getQuat<quat)
			{
				quat=sa.get(i).getQuat;
				cemi=i;
			}
			else(sa.get(i).getDist == 800 && sa.get(i).getOit<oit)
			{
				oit = sa.get(i).getOit;
				oiti=i;
			}
		}
		for(int i=0;i<co.size();i++)
		{
			if(co.get(i).getModalidade.equals("Altura") && co.get(i).getAlt>alt)
			{
				alt=co.get(i).getAlt;
				alti=i;
			}
			else if(co.get(i).getModalidade.equals("Comprimento") && co.get(i).getComp>comp)
			{
				comp=co.get(i).getComp;
				compi=i;
			}
		}
		//Adicionar seleccionados ao Array sel:
		for(int i=0;i<sa.size();i++)
		{
			Atleta atleta1 = sa.get(cemi).getNome();
			sel.add(atleta1);
			Atleta atleta2 = sa.get(quati).getNome();
			sel.add(atleta2);
			Atleta atleta3 = sa.get(oiti).getNome();
			sel.add(atleta3);
		}
		for(int i=0;i<co.size();i++)
		{
			Atleta atleta4 = sa.get(compi).getNome();
			sel.add(atleta4);
			Atleta atleta5 = sa.get(alti).getNome();
			sel.add(atleta5);
		}
	}
}	
