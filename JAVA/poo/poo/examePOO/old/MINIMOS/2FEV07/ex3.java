package R2007;

public class Merge {
	public static void main(String[]args){
		
		int n=0;        
		int l=0;
		int j=0;
		executante ma[] = new executante[n];
		executante mb[] = new executante[n];
		executante m2[] = new executante[ma.length + mb.length+1];
		maestro mt[] = new maestro[2];
		
		for(int i=0;i<ma.length;i++){
			m2[j]=ma[i];
			j++;
		}
		for(int i=0;i<mb.length;i++){
			m2[j]=ma[i];
			j++;
		}
		
		int older=0;
		
		for(int i=0;i<maestro.length;i++){
			if(older<mt[i].ano){
				older=i;
			}
		}
		m2[0]=older;
		
	}
}

