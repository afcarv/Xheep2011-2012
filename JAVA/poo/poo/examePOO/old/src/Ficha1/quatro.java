package Ficha1;


public class quatro {

public static void main(String[] args) {
	int n,i,resultado=0;
	
	System.out.print("introduza o numero: ");
	n=User.readInt();
	
	for(i=0;i<=3;i++){
		while(resultado<100){
		resultado=n*i;
		System.out.println(+resultado);
		break;
		}
	}
}
}
