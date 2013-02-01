package resolucoes;

import common.User;

public class Exc1 {
	public static void main(String[] args){
		String s;
		
		System.out.print("String: ");
		s = User.readString();
		
		if (palindroma(s))
			System.out.print(s+" e um palindroma.");
		else
			System.out.print(s +" nao e um palindroma.");
		
	}
	
	public static boolean palindroma (String s){
		for(int i=0;i < s.length()/2;i++)
			if (s.charAt(i)!= s.charAt(s.length()-(i+1)))
					return false;
		
		return true;
	}

}
