package resolucoes;

import common.User;

public class Exc2 {
	public static void main(String[] args){
		String s;
		String vogais = "aeiou";
		String r;
		
		System.out.print("String: ");
		s = User.readString();
		
		r = insere (s,"p",vogais);
		
		System.out.print("O resultado e " + r + ".");
	
	}
	
	public static String insere (String s, String novo, String controlo){
		char l1;
		char l2;
		String in;
		String t;
		
		for (int i=0;i< s.length()-1;i++){
			l1=s.charAt(i);
			l2=s.charAt(i+1);
			
			if (in(controlo,l1) && in(controlo,l2)){
				t = s.substring(i+1);
				in = s.substring(0, i+1);
				s=in.concat(novo);
				s=s.concat(t);
			}
		}
		
		return s;
	}
	
	public static boolean in (String s, char c){
		//Devolve true se c esta em s
		
		for(int i=0;i<s.length();i++){
			if(s.charAt(i)==c)
				return true;
		}
		
		return false;
	}

}
