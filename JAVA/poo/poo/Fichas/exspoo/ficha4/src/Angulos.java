
public class Angulos { //vai ser a função main e tem de ser implementada num contexto à parte das classes

	public static void main(String[] args) {
		
		double a1,a2;
		
		System.out.println("a1: ");
		a1=User.readInt();
		
		System.out.println("a2: ");
		a2=User.readInt();
		
		Angulo ang1 = new Angulo(a1);//ang1 é uma objecto da classe angulo que vai receber o valor de a1
		Angulo ang2 = new Angulo(a2);
		
		Angulo ang3; //declaro ang3
		
		ang3 = new Angulo(ang1.adicao(ang2).graus);//caso contrario tinha de criar um construtor que recebesse paramentros do tipo Angulo (tal como o prof tinha feito)
//a classe angulo devolve valores de tipo ANGULO é preciso passá-lo para graus daí o .graus
		
		if (ang3.equals(a1)){
			System.out.println("os angulos"+ang3+"e"+a1+" sao iguais");
		
			System.out.println(ang3.sin());
			System.out.println(ang3.cos());
			System.out.println(ang3.tan());
		}
	}
	
	
}

