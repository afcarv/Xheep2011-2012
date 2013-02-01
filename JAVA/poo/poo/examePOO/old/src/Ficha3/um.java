package Ficha3;

public class um {
	
	public static void main (String[]args){
		
	String palavra = "anaaaae";
	
	for(int i=0;i<palavra.length()/2;i++){
		//for(int j =palavra.length()/2;j<0;j--){
			if(palavra.charAt(i) != palavra.charAt(palavra.length()-(1+i))){
				System.out.println("Não é palíndromo");
				return;
		//}	
	}
			
	}
	System.out.println("Olha, volta e meia é mesmo um palíndromo.");
	
	
	}
}