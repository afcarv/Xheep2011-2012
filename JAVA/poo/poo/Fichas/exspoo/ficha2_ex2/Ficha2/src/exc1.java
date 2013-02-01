import Common.User;



public class exc1 {
	public static void main (String[] args){
		int a[] = {1,2,3};
		int b[] = {56,87,12};
		int ab[];
		
		ab = doMerge(a,b);
		
		for (int i =0;i<ab.length;i++)
			System.out.print(ab[i]+" ");
	}
	
	public static int[] doMerge (int[]a, int []b){
		int []ab = new int [a.length + b.length];
		int l = 0;
		
		for (int ia = 0, ib = b.length-1; ia < a.length; ia++,ib--){
			ab[l++]=a[ia];
			ab[l++]=b[ib];
		}
		return ab;
	}

}
