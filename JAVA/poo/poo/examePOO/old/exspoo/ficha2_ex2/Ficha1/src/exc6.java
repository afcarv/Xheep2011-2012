import Common.User;


public class exc6 {
	public static void main (String[] args){
		int l=0;
		
		while (l<=3){
			System.out.print("Limite: ");
			l = User.readInt();
			ln();
		}
		
		for (int i=4;i<=l;i++)
			if (perfeito(i)==1){
				imprime_perf(i);
				ln();
			}
		
	}
	
	public static void ln (){
		System.out.println("");
	}
	
	public static void imprime_perf (int n){
		int v[];
		
		v = exc5.divisores_amg(n);
		
		System.out.print("Numero Perfeito: "+n);
		
		ln();
		
		System.out.print("Factores:");
		for (int i=1;i<=v[0];i++)
			System.out.print(" "+v[i]);
		
		ln();
	}
	
	public static int perfeito (int n){
		int res[];
		int s;
		
		res = exc5.divisores_amg(n);
		s = exc5.soma_vector_amg(res);
		
		if (s == n)
			return 1;
		else
			return 0;
	}
	
	

}
