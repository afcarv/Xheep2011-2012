package Ficha1;

public class cinco {

public static void main(String[] args) {

	int i,numero1,numero2,soma1=0,soma2=0;
	
	System.out.print("numero1: ");
	numero1=User.readInt();
	
	System.out.print("numero2: ");
	numero2=User.readInt();
	
	for (i=1;i<999;i++){
		if (numero1%i==0 && i!=numero1){
			soma1+=i;
			}
		if (numero2%i==0 && i!=numero2){
			soma2+=i;
		}
	}
	if (soma1==numero2 && soma2==numero1){
		System.out.print (+numero1 + " e " +numero2 + " sao numeros amigos");}
	else{
		System.out.print ("NAO");
	}
}
}
