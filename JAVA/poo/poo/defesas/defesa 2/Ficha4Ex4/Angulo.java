package Ficha4Ex4;

import common.User;

class Angulo{
	double graus=0;
	
	Angulo(){};
	
	Angulo(double a){
		graus=a;
	}
	Angulo adiciona(Angulo a){
		return new Angulo(a.graus+graus);
	}
	double cos(){
		return Math.cos((graus*2*Math.PI)/360);
	}
	double sen(){
		return Math.sin((graus*2*Math.PI)/360);
	}
	double tan(){
		return Math.tan((graus*2*Math.PI)/360);
	}
	boolean equals(Angulo a){
		while(graus>360)
			graus=graus-360;
		while(a.graus>360)
			a.graus=a.graus-360;
		if(a.graus==graus)
			return true;
		else
			return false;
	}
	double RadToGrau(Double rad){
		return ((180*rad)/Math.PI);
	}
	double radianos(){
		return (graus*2*Math.PI)/360;
	}
	String totoString(){
		return "angulo de "+ graus +" graus ";
	}
	public static void main(String[] args) {
		Angulo a1=new Angulo(User.readDouble());
		Angulo a2=new Angulo(User.readDouble());
		System.out.println(a1.adiciona(a2).totoString());
		System.out.println("Radianos "+ a1.adiciona(a2).radianos()+" ("+(a1.adiciona(a2).radianos())/(Math.PI)+" PI )");
		System.out.println("cos "+a1.adiciona(a2).cos());
		System.out.println("sin "+a1.adiciona(a2).sen());
		System.out.println("tg "+a1.adiciona(a2).tan());
		System.out.println("Iguais? "+ a1.equals(a2));
	}
}
