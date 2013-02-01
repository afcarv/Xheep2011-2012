
public class exc2 {
	public static void main(String[] args){
		int [][]a = {{2,2},{2,2}};
		int [][]b = {{3,3},{3,3}};
		int [][]ab;
		
		ab = mul (a,b);
		
		for (int i = 0;i<b.length;i++){
			System.out.println(" ");
			for (int j = 0;j<b.length;j++){
				System.out.print(ab[i][j] + "");
				
			}
		}
		
	}
	
	public static int [][] mul (int [][]a, int [][]b){
		
		if (a[0].length != b.length)
			return null;
		
		int ab[][] = new int [a.length][b[0].length];
		
		for (int aRow=0; aRow<a.length;aRow++)
			for (int bCol = 0; bCol < (b[0].length);bCol++){
				ab[aRow][bCol]=0;
				for (int k=0;k<a[0].length;k++)
					ab[aRow][bCol] += a[aRow][k]*b[k][bCol];
			}
		
		return ab;
	}

}
