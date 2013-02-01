
public class multiplacacao_matrizes {

	/**
	 * @param args
	 */

	public static void main(String[] args) {
		// TODO Auto-generated method stub

		int a[][],b[][],ab[][], k;
		
		a = new int[2][2];
		b = new int [2][2];
		ab = new int [2][2];
	
		System.out.print("preencha array a: ");
		for (int i = 0; i < 2; i++) {   
			  for (int p = 0; p < 2; p++) {   
			    a[i][p] = User.readInt();
			    System.out.print("novo numero p/ array a: ");
			  }
		}
		
		System.out.print("preencha array b: ");
		for (int m = 0; m < 2; m++) {
			for (int n = 0; n < 2; n++) {
				b[m][n] = User.readInt();
			  }
			}  
		
		for (int aRow=0; aRow<a.length; aRow++){
			for (int bCol=0; bCol<b[0].length; bCol++){
				ab[aRow][bCol]=0;
				for (k=0; k<a[0].length; k++){
					
					ab[aRow][bCol]+=a[aRow][k] * b[k][bCol];
				}
			}
		}
		for (int m = 0; m < 2; m++) {
			for (int n = 0; n < 2; n++) {
				System.out.println(ab[m][n]);
			  }
			}  
		
		
	}
}


