import Common.User;


public class exc5 {
	public static void main (String[] args){
		int n,m,s_n,s_m;
		int res_n[],res_m[];
		
		System.out.print("n: ");
		n=User.readInt();
		
		System.out.print("m: ");
		m = User.readInt();
		
		res_n =divisores_amg (n);
		s_n = soma_vector_amg (res_n);
		
		res_m = divisores_amg (m);
		s_m = soma_vector_amg (res_m);
		
		if (s_m == n && s_n == m)
			System.out.print(n+ " e " + m + " sao amigos!");
		else
			System.out.print(n+ " e " + m + " nao sao amigos!");
		
		
	}
	
	public static int soma_vector_amg (int[] v){
		int res=0;
		
		for (int i=1;i<=v[0];i++)
			res += v[i];
		
		return res;
	}
	
	public static int[] divisores_amg (int n){
		int res[]= new int [100];
		int p=1;
		
		for (int i=1; i<n;i++)
			if (n%i==0)
				res[p++]=i;
		res[0]=p-1;
		return res;
		
	}
	
	

}
