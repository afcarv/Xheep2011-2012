
public class exercicio3 {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		int n;
		
		System.out.print("introduza o limite maximo: ");
		n=User.readInt();
		
		int primos [] = new int [n - 1];
		final int NAOEPRIMO = 1;
		
		for (int d=2;d <= n;d++){ 				//coloca os numeros de 2 a n no array primos
			primos[d - 2] = d;					// vai cortar os numeros primos que sao multiplos atribuindo NAOEPRIMO
		}
		
	//	System.out.println("filling done");
		
		for (int i=0; i < n - 1; i++){
			if (primos[i] != NAOEPRIMO){
				
	//			System.out.println("entering search for multipliers - done");
				
				for (int j=i + 2; j<n; j++){
					if((i + 2)*j<=n){
						primos[(i + 2)*j - 2]=NAOEPRIMO;
					}
					else{
						
	//					System.out.println("breaking -> (i+2)*j = " + (i + 2)*j);
						
						break;
					}
					
			//		System.out.println("Status: i = " + (i + 2) + " j = " + j + " i*j = " + (i + 2)*j);
				
				}
			}
			else{
			//	System.out.println("O número primos[" + i + "] não é primo. Passamos.");
			}
		}
		
		for (int h=0; h < n - 2;h++){
			if (primos[h]!=NAOEPRIMO){
				System.out.print(primos[h] + " ");
			}
		}
	}
}