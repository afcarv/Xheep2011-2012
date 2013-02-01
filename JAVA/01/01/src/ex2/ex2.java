/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package ex2;


/**
 *
 * @author user
 */

/*
 
 
 */

public class ex2 {
 
    public static void main(String[] args) { 
    {
        int limite;
        System.out.println("\nInsira o limite:");
        limite = User.readInt();
        int valor = 0 ;
        int soma =0 ;
        
        for (int i=0;i<limite;i++){
            soma +=i;
            if (soma >= limite)
            {
                System.out.println("Limite atingido com valor: "+soma);
                break;
            }
            
        
        }
    
    }
    
}
}