
public class replicacaoalgarismos {

	public static void main (String[] args) {
		
		int n,i,numero,x=10,ultimo_digito,ultimo_digito2,novo_numero,k=10;
		
		System.out.print("introduza numero de algarismos a verificar: ");
		n=User.readInt();
		
		System.out.print("introduza numero: ");
		numero=User.readInt();
		
		novo_numero=(int) Math.pow(numero, 2);
		System.out.print("numero ao quadrado: "+novo_numero);
		
		for (i=1;i<=n;i++){
			while (numero>0 && novo_numero>0){
				ultimo_digito=numero%x;
				ultimo_digito2=novo_numero%x;
				if (ultimo_digito==ultimo_digito2){
					System.out.print("\n"+"este numero esta contido");	
					novo_numero=novo_numero/k;
					numero=numero/k;
				}
				else{
					System.out.print("\n"+"nao esta contido");
					novo_numero=novo_numero/k;
					numero=numero/k;
					x*=10;
				}
			}
		}
	}
			
}