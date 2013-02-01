/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author user
 */
public class palindromo {
 
    public static void main (String []Args){
        //palindromo.charAt(i)
        
        String palindromo;
        System.out.print("\nInsira uma palavra:");
        palindromo = User.readString();
        int tamanho = palindromo.length();
        System.out.println("\nlength:"+tamanho);
        //System.out.print("\nEsta palavra "+palindromo+"tem "+tamanho+" digitos.");
        for (int i=0; i<tamanho/2; i++){
            for (int j=tamanho; j>tamanho/2; j--){
                System.out.println("\nCaracter i:"+palindromo.charAt(i));
                System.out.println("\nCaracter j:"+palindromo.charAt(j));
                if (palindromo.charAt(i) == palindromo.charAt(j)){
                    continue;
                }
                else{
                    System.out.println("Não se trata de um palindromo, a palavra ->"+palindromo);
                break;
                }
            }
        }
        
        
        
    }
    
}
