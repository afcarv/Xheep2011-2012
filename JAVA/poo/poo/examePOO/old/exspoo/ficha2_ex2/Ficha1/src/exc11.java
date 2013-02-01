import Common.User;
import Common.lf;


public class exc11 {
	public static void main(String[] args){
		int r,limite_inf=0,limite_sup=0;
		
		System.out.print("Limite inferior: ");
		limite_inf = User.readInt();
		
		lf.ln();
		
		System.out.print("Limite superior: ");
		limite_sup = User.readInt();
		
		for (int i=limite_inf;i<=limite_sup;i++)
			for (int j=limite_inf;j<=limite_sup;j++){
				r = mmc (i,j);
				
				print_mmc (i,j,r);
			}
		
	}
	
	
	public static void print_mmc (int i, int j, int r){
		lf.ln();
		System.out.print("Mmc de "+i+" e "+j+" -> "+r);
		lf.ln();
	}
	
	public static int mmc (int n, int m){
		for (int i=1;i<=m;i++){
			for (int j=1;j<=n;j++){
				if (n*i == m*j)
					return n*i;
			}
		}
		
		return 0;
	}

}
