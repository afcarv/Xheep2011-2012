
public class merge {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		
		
		int a[]={1,2,3,4,5,6};
		int b[]={10,11,12,13,14,15};
		
		doMerge(a,b);
		
		
		
		// TODO Auto-generated method stub

	}
	
	
	static int [] doMerge(int a[],int b[]){ //devolve um array do tipo inteiro
		
		
		int ab[]= new int[a.length + b.length];//ab vai ter o tamanho dos 2 arrays
		int l=0;
		int ia, ib;
		for (ia=0, ib=b.length-1;ia<=a.length-1;ia++,ib--){
			ab[l++]=a[ia];
			ab[l++]=b[ib];
			
		}
		for (int i=0; i<=ab.length-1;i++){
			System.out.print(ab[i] + " ");
		}
		return ab;
		
	}
}
	