package Exame3;

import java.util.ArrayList;

public class Loja {

	//Exerc�cio 2:
	public void remove(String marca, String modelo, ArrayList<Dispositivos> Stock)
	{
		ArrayList <Dispositivos> di = new ArrayList <Dispositivos>();
		//Pesquisa na lista dispositivos Marca e Modelo:
		for(int i=0;i<di.size();i++)
		{
			//Se encontra cria objecto desse tipo:
			if(di.get(i).marca.equals(marca)&&di.get(i).modelo.equals(modelo))
			{
				//Guarda num serie do equipamento para eleminar do stock:
				Dispositivos disp = di.get(i).numSerie();
				//Remove um elemento da lista de num de serie:
				for(int j=0;j<Stock.size();i++)
				{
					Dispositivos dp = Stock.get(i).numSerie();
					if(disp.equals(dp))
					{	
						//remove n�mero de s�rie encontrado:
						Stock.remove(dp);
						//Se o total de dispositivos � inferior ao m�nimo->alerta
						if(Stock.get(i).Stock_min<Stock.size())
						{
							System.out.println("Vai reabastecer.");
						}
					}
				}
			}
			else 
			{
				System.out.println("Dispositivo n�o encontrado.");
			}
		}
	}

	//Exerc�cio 3:
	public void saldos()
	{
		float precoT=0;
		ArrayList <Dispositivos> di = new ArrayList <Dispositivos>();
		//Percorre dispositivos para determinar pre�o total:
		for(int i =0;i<di.size();i++)
		{
			//objecto disp para saber pre�o por marca/modelo:
			Dispositivos disp = di.get(i).preco();
			//Se � um telem�vel:
			if(di.get(i).tipo.equals("Telem�vel"))
			{
				precoT+= disp.preco*0.95;
			}
			//se port�til � preciso saber quantos Stock.size>stock min:
			else if(di.get(i).tipo.equals("Port�til"))
			{
				//determina diferen�a entre qtdade de stock e stock min
				double acimas=disp.Stock.size()-disp.Stock_min;
				if(acimas>0)
				{
					precoT+= disp.preco-((0.1*disp.preco)*acimas);
				}
				else
				{
					precoT+= disp.preco*0.95;
				}
			}
		}
	}
}
