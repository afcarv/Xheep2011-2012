package Ficha3;

import java.util.StringTokenizer;


public class tokenizer {

	
	public static void main(String[] args) {
		
		
		String frase;
		
		System.out.print("introduza uma string(frase): ");
		frase = User.readString();
		
		tiraPalavraComAs(frase);
		
	}

	public static void tiraPalavraComAs(String mais){

		String palavrasComAs = "";
		String getPalavra = "";
		StringTokenizer word = new StringTokenizer(mais);
		
		while (word.hasMoreTokens()){
			
			// vai buscar palavras à string frase:
			getPalavra = word.nextToken();
			
			// e envia a palavra actual(nexttoken) para a função countAs:
			if (countAs(getPalavra)>1){
				palavrasComAs += " " + getPalavra;
			}
		}
		System.out.print("string final: " +palavrasComAs);
		
	}
	//conta número de as de um token:
	public static int countAs(String palavra){
		int na = 0;
		for (int i=0; i<palavra.length();i++){
			if (palavra.charAt(i)=='a' || palavra.charAt(i)=='A'){
				na++;
			}
		}
		return na;
	}
}