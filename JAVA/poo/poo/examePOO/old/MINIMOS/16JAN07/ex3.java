package N2007;

public class Equipa2 {
	public static void main(String[]args){
		
		int n=0;
		 
		Corrida c[] = new Corridor[n];
		Salto s[] = new Salto[n];
		//variáveis para guardar tempos e saltos:
		int maisRapido800=0;
		int maisRapido400=0;
		int maisRapido100=0;
		int maximoAl=0;
		int maximoComp=0;
		
		//variáveis para guardar tempos e saltos:
		int indice800=0;
		int indice400=0;
		int indice100=0;
		int indiceAl=0;
		int indiceComp=0;
				
		//Corredor de 800 m mais rapido:
		for(int i=0;i<c.length;i++){
			if(c[i].distancia.equals("800") && c[i].tMin>maisRapido800){
				maisRapido800=c[i].tMin;
				indice800=i;
			}
		}
		//Corredor de 400 m mais rapido:
		for(int i=0;i<length;i++){
			if(c[i].distancia.equals("400") && c[i].tMin>maisRapido400){
				maisRapido400=c[i].tMin;
				indice400=i;
			}
		}
		//Corredor de 100 m mais rapido:
		for(int i=0;i<length;i++){
			if(c[i].distancia.equals("100") && c[i].tMin>maisRapido100){
				maisRapido100=c[i].tMin;
				indice100=i;
			}
		}
		//Melhor saltador em altura:
		for(int i=0;i<length;i++){
			if(s[i].modalidade.equals("altura") && s[i].sMax>maximoAl){
				maximoAl=s[i].sMax;
				indiceAl=i;
			}
		}
		//Melhor saltador em altura:
		for(int i=0;i<length;i++){
			if(s[i].modalidade.equals("comprimento") && s[i].sMax>maximoComp){
				maximoComp=s[i].sMax;
				indiceComp=i;
			}
		}
		System.out.println("Os seleccionados para o campeonato x72 são:"+maisRapido800,maisRapido400,maisRapido100,maximoAl,maximoComp);
	}
}
