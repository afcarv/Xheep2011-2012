import Common.User;


public class exc4 {
	public static void main (String[] args){
		int n;
		int res[];
		
		System.out.print("n: ");
		n = User.readInt();
		
		if (n==0)
			System.out.println("Os resultados sao: 0 0 0 0");
		else
		{
			res = mul_men_100 (n);
			
			System.out.println("Os resultados sao: ");
			System.out.print("0");
			for (int i = 0;i<4;i++){
				if (res[i]!=0)
					System.out.print(" "+res[i]);
			}
		}
	}
	
	public static int[] mul_men_100 (int n){
		int res[]={0,0,0,0};
		int t;
		
		for (int i=1;i<=3;i++){
			t = i*n;
			
			if (t<=100 && t>0)
				res[i-1]=t;
			else
				res[i-1]=0;
		}
		
		return res;
	}
}
