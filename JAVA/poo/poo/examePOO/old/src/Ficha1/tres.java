package Ficha1;


public class tres {

public static void main(String[] args) {
	int numero,i=0,conta=0,resto,d,decimal=0,uns=0,zeros=0;
	System.out.print ("introduza um numero em binario: ");		
	numero = User.readInt();
	while(numero>0){
	resto= numero%10;		
	numero=numero/10;
	conta++;
	if (resto==0){
		zeros++;
	}
	if (resto==1){
		uns++;
	}
	
	decimal+=resto*Math.pow(2, conta-1);
	}
	System.out.println("zeros: "+zeros+"\n"+"uns: "+uns+"\t"+"decimal: "+decimal+"conta ="+conta);
	}
}