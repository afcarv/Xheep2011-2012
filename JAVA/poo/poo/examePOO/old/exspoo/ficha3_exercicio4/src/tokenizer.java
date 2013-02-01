import java.util.StringTokenizer;


public class tokenizer {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		String frase;
		
		System.out.print("introduza uma string(frase): ");
		frase = User.readString();
		
		tiraPalavraComAs(frase);
		
	}

	public static void tiraPalavraComAs(String mais){

		String palavrasComAs = "";
		String getPalavra = "";
		StringTokenizer componentes = new StringTokenizer(mais);
		
		while (componentes.hasMoreTokens()){
			getPalavra = componentes.nextToken();
			if (countAs(getPalavra)>1){
				palavrasComAs += " " + getPalavra;
			}
		}
		System.out.print("string final: " +palavrasComAs);
		
	}
	
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