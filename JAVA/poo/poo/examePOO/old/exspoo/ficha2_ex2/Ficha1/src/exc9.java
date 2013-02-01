import Common.User;


public class exc9 {
	public static void main (String[] args){
		int l;
		
		System.out.print("Limite: ");
		
		l=User.readInt();
		
		for (int i=2;i<=l;i++)
			if (ePrimo(i)==1)
				System.out.println(i+" e primo.");
		
	}
	
	public static int ePrimo (int x){
		
		for (int i=2;i<x;i++)
			if (x%i == 0)
				return 0;
		return 1;
	}

}
