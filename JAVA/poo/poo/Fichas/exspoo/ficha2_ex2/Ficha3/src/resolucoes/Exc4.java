package resolucoes;

import java.util.*;

import common.User;

public class Exc4 {
	public static void main(String[] args){
		String s;
		String r;
		
		System.out.print("String: ");
		s = User.readString();
		
		r = conversor (s);
		
		System.out.print(r);
		
	}

	public static String conversor (String s){
		StringTokenizer tokens = new StringTokenizer (s);
		String t;
		String r="";
		int n;
		
		while(tokens.hasMoreElements()){
			t = tokens.nextToken();
			n = conta_chars(t,'a');
			if (n >= 2){
				if (r.length() != 0)
					r=r.concat(" ");
				r=r.concat(t);
			}
		}
		
		return r;
	}
	
	public static int conta_chars (String s, char c){
		int r=0;
		
		for (int i=0;i<s.length();i++)
			if (s.charAt(i)==c)
				r++;
		return r;
	}
}
