import Common.User;
import Common.lf;


public class exc4 {
	public static void main (String[] args){
		long [][] s;
		int v[];
		int l,c;
	
		
		s = sudoku();
		
		for (int i=0;i<9;i++){
			lf.ln();
			for (int j=0;j<9;j++)
				System.out.print(" "+s[i][j]);
		}
		
	
		lf.ln();
		System.out.print("linha: ");
		l=User.readInt();
		
		lf.ln();
		System.out.print("coluna: ");
		c=User.readInt();
		
		
		v=livres_sudoku(s,l,c);
		
		lf.ln();
		System.out.print("Numeros possiveis: ");
		lf.ln();
		for (int i=0;v[i]!=0;i++)
			System.out.print(v[i]+" ");
		
		
	}
	
	public static int[] livres_sudoku (long [][]t, int i, int j){
		int[] v= new int[9];
		int l=0;
		
		for (int n=1;n<10;n++)
			if (verf_sudoku(n,t,i,j))
				v[l++]=n;
		
		return v;
		
	}
	
	public static long[][] sudoku (){
		//A existencia do esquema associado a variavel d serve
		//para reduzir o numero de 0's na matriz final.
		
		long t[][]= new long [9][9];
		long n=0;
		boolean d=true;
		
		for (int i=0;i<9;i++)
			for (int j=0;j<9;j++){
				n = Math.round(Math.random()*100);
				n %= 10;
				
				if (d && verf_sudoku(n,t,i,j)){
					t[i][j]=n;
					if (n==0)
						d=false;
				}
				else if (verf_sudoku(n,t,i,j)){
					if (n!=0){
						t[i][j]=n;
						d=true;
					}
				}
			}
		
		return t;
		
	}
	
	public static boolean verf_sudoku (long n, long[][] t,int i, int j){
		int x,y;
		
		if (n==0)
			return true;
		
		for (int l=0;l<9;l++)
			if (t[l][j]==n)
				return false;
		
		for (int c=0;c<9;c++)
			if (t[i][c]==n)
				return false;
		
		for (x= i - i%3;x< i -i%3 +3;x++)
			for (y= j - j%3;y < j - j%3 + 3;y++)
				if (t[x][y]==n)
					return false;
		
		
		return true;
		
	}

}
