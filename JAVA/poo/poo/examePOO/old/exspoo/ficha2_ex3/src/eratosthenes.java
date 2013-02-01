
public class eratosthenes {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		int n;
		
		System.out.print("introduza o limite maximo: ");
		n=User.readInt();
		
		int primos [] = new int [n];
		
		for (int d=2;d<=n;d++){ //coloca os numeros de 2 a n no array primos
			primos[d-2]=d;
		}
		
		final int NAOEPRIMO = 1;
		
		
		for (int i=2; i<=n; i++){
			for (int j=2; j<=n; j++){// vai cortar os numeros primos que sao multiplos atribuindo NAOEPRIMO
					if ((i*j)<=n){
						primos[(i*j)-2]=NAOEPRIMO;
					}
					else{
						break;
					}
			}
		}
		
		for (int h=0 ; h < n-1 ; h++){
			if (primos[h]!=NAOEPRIMO){
				System.out.print(primos[h] + " ");
			}
		}
	}
}
