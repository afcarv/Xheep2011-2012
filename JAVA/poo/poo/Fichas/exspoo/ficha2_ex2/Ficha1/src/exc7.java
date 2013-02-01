public class exc7 {
	public static void main (String[] args){
		int limite_inf,limite_sup;
		
		limite_inf = 100;
		limite_sup = 999;
		
		System.out.print("Entre "+limite_inf+" e "+limite_sup+" os numeros com a caracteristica sao:");
		
		ln();
		
		for (int i=limite_inf;i<=limite_sup;i++)
			if (caracteristica(i) == 1)
				System.out.println(i);
	}
	
	public static int caracteristica (int n){
		int r=0,b_n=n;
		
		while (n>0){
			r += Math.pow((n%10), 3);
			n /= 10;
		}
		
		if (r==b_n)
			return 1;
		else
			return 0;
		
	}
	
	public static void ln (){
		System.out.println("");
	}
}