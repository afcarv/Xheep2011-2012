
public class Ete1 {

	public static void main(String[] args){
		int i;
		
		
		System.out.println("Inezinha, insere uma palvra:>");
		String palavra = User.readString();
		
		
		for (i=0;i<palavra.length()/2;i++){
			if(palavra.charAt(i) != palavra.charAt(palavra.length()-(1+i))){
				System.out.println("Olha Inezinha, "+palavra+" n�o � um pal�ndromo.");
				return;
			}	
			else{
				System.out.println("Inezinha, "+palavra+"  � de facto um pal�ndromo.");
				return;
			}
		}	
	}
}
