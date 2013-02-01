import Common.User;


public class exc8 {
	public static void main (String[] args){
		int n, limite_sup=0, limite_inf=0;
		
		System.out.print("Numero de algarismos: ");
		n = User.readInt();
		
		limite_sup += Math.pow(10, n) - 1;
		limite_inf += Math.pow(10,n-1);
		
		System.out.println("n="+n+":");
		for (int i=limite_inf;i<=limite_sup;i++)
			if (menos_sig(n,i) == 1)
				System.out.println(i);
		
	}
	
	public static int menos_sig (int a, int n){
		int p=0;
		
		p += Math.pow(n, 2);
		
		p %= Math.pow(10,a);
		
		if (p==n)
			return 1;
		else
			return 0;
		
	}

}
