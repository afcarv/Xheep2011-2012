import java.util.StringTokenizer;


public class Conta_palavras {
	public static void main(String[] args) {
		
		System.out.print("introduza a frase: ");
		String frase = User.readString();
		
		verificarPalavra(frase);
	}
	
	public static void verificarPalavra(String frase){
		int n=0;
		
		System.out.print("verificar palavra: ");
		String palavra = User.readString();
		
		StringTokenizer componentes=new StringTokenizer(frase);
		
		while (componentes.hasMoreElements()) {
			if (componentes.nextToken().compareTo(palavra)==0) { //ou palavra.equals(frase.nextToken())
				n++;
			}
		}
		System.out.print("numero de vezes que palavra aparece: "+n);
	}
}