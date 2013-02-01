
public class Ete2 {

	public static void main(String[] args){
		
		int i=0;
		
		
		
		System.out.println("Oixx.Td bein?olha, bota aí uma palvra para eu por um p no meio das vogais ok Inezinha?");
		String palavra = User.readString();
		String c = User.readString();
		
		//length-1 porque não se deve ir buscar o último caracter --> erro
		
		for (i = 0; i < palavra.length()-1; i++)
		{
			//envia para isVogal 2 caracteres, o "actual" e o seguinte para verificar se ambos são vogal:
			if (isVogal(palavra.charAt(i)) && isVogal(palavra.charAt(i+1)))
			{
				palavra = palavra.substring(0, i+1) + 'p' + palavra.substring(i+1);
			}
			
			
		}
		System.out.println("Olha Inezinha, aí vai a palavra com um 'p' no meio das vogais ;b. Beijo(vamos fazer triqui triqui agora?) " +palavra);
	
		
		
		
		}

	public static boolean isVogal(char c)
	{
		char[] vogais = {'a','e','i','o','u'};
		
		for (int i = 0; i < vogais.length; i++)
		{
			if (vogais[i] == c)
			{
				return true;
			}
		}
		return false;
	}
}
