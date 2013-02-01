package resolucoes;

import java.util.StringTokenizer;
import java.lang.Integer;

import common.User;

public class Exc5 {
	public static void main(String[] args){
		//Um ISBN valido e "0 8 9 2 3 7 0 1 0 6"
		
		String s;
		int n;
		int s1[] = new int[10];
		int s2[] = new int[10];
		int i=0;
		
		System.out.print("ISBN a verificar: ");
		s = User.readString();
		
		StringTokenizer tokens = new StringTokenizer (s);
		
		while(tokens.hasMoreElements()){
			n = Integer.parseInt(tokens.nextToken());
			
			if (i==0){
				s1[i++]=n;
				s2[0]=n;
			}
			else{
				s1[i] = s1[i-1] + n;
				s2[i] = s2[i-1] + s1[i];
				i++;
			}
		}
		
		System.out.println("");
		
		System.out.print("ISBN original "+ s);
		
		System.out.println("");
		
		System.out.print("Somas parciais (s1) ");
		for(int j=0;j<s1.length;j++)
			System.out.print(s1[j]+" ");
		
		System.out.println("");
		
		System.out.print("Somas totais (s2) ");
		for(int j=0;j<s2.length;j++)
			System.out.print(s2[j]+" ");
		
		System.out.println("");
		System.out.println("");
		
		if (s2[9]%11 == 0)
			System.out.print("O ISBN dado é correcto pois " + s2[9] + " é divisível por 11.");
		else
			System.out.print("O ISBN dado não é correcto pois " + s2[9] + " não é divisível por 11.");
		
	}

}
