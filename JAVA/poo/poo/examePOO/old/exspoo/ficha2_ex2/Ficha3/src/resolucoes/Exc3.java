package resolucoes;

import common.User;

public class Exc3 {
	public static void main(String[] args){
		String frase;
		String palavra;
		int c;
		
		System.out.print("Frase: ");
		frase=User.readString();
		
		System.out.print("Palavra: ");
		palavra=User.readString();
		
		
		c=conta_palavras(frase, palavra);
		
		System.out.printf("O numero de vezes que %s ocorre e %d.\n", palavra,c);
		
	}
	
	public static int conta_palavras (String frase, String palavra){
		int c=0;
		int index=0;
		char chr_i;
		char chr_f;
		
		while (true){
			chr_i=' ';
			chr_f=' ';
			
			index=frase.indexOf(palavra, index);
			if (index != -1){
				
				if (index != 0)
					chr_i=frase.charAt(index-1);
				
				if (index < (frase.length() - palavra.length() - 1 ))
					chr_f = frase.charAt(index + palavra.length());
				
				if (chr_i == ' ' && chr_f == ' ')
					c++;
				
				index+= palavra.length();
			}
			if(index>=frase.length() || index<0)
				break;
		}
		
		return c;
	}
}
