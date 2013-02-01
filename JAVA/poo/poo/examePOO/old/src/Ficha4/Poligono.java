package Ficha4;

class Poligono{
	Ponto [] pontos;
	Angulo [] angulos;
	double [] lados;

	//construtor:
	Poligono(){};
	
	//construtor:
	Poligono(int num){
		pontos=new Ponto[num];

		for(int i=0;i<num;i++){
			System.out.print("\n *--Vertice "+(i+1)+"--* \n");
			double x,y;
			System.out.print("Abcissa: ");
			x=User.readDouble();
			System.out.print("Ordenada: ");
			y=User.readDouble();
			pontos[i]=new Ponto(x,y);
		}
		CriaLados(num);
		CriaAngulos(num);
	}
	
	//verifica se lados são iguais:
	boolean VerificaLados(){
		for(int i=0;i<(lados.length-1);i++){
			if(lados[i]!=lados[i+1])
				return false;
		}
		return true;
	}
	
	void CriaLados(int num){
		lados=new double[num];
		for(int i=0;i<(num-1);i++){
			lados[i]=Math.sqrt(Math.pow(this.pontos[i].x-this.pontos[i+1].x,2)+Math.pow(this.pontos[i].y-this.pontos[i+1].y,2));
		}
		lados[num-1]=Math.sqrt(Math.pow(this.pontos[0].x-this.pontos[num-1].x,2)+Math.pow(this.pontos[0].y-this.pontos[num-1].y,2));
	}
	
	void CriaAngulos(int num){
		angulos=new Angulo[num];
		angulos[0]=new Angulo((180*Math.acos((((this.pontos[1].x-this.pontos[0].x)*(this.pontos[num-1].x-this.pontos[0].x))+((this.pontos[1].y-this.pontos[0].y)*(this.pontos[num-1].y-this.pontos[0].y)))/(this.lados[0]*this.lados[num-1])))/Math.PI);
		for(int i=1;i<=(num-2);i++)
			angulos[i]=new Angulo((180*Math.acos((((this.pontos[i+1].x-this.pontos[i].x)*(this.pontos[i-1].x-this.pontos[i].x))+((this.pontos[i+1].y-this.pontos[i].y)*(this.pontos[i-1].y-this.pontos[i].y)))/(this.lados[i-1]*this.lados[i])))/Math.PI);	
		angulos[num-1]=new Angulo((180*Math.acos((((this.pontos[0].x-this.pontos[num-1].x)*(this.pontos[num-2].x-this.pontos[num-1].x))+((this.pontos[0].y-this.pontos[num-1].y)*(this.pontos[num-2].y-this.pontos[num-1].y)))/(this.lados[num-1]*this.lados[num-2])))/Math.PI);
	}
	
	boolean VerificaAngulos(){
		for(int i=0;i<(angulos.length-1);i++){
			if(angulos[i].graus!=angulos[i+1].graus)
				return false;
		}
		return true;
	}
}
