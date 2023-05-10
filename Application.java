/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.entities;

/**
 *
 * @author zeus
 */
public class Application { 
    private double id,id_user,num;

    private String role,location;

    private String document;

    public Application() {
    }

    public Application(double id, double id_user, double num, String role, String location, String document) {
        this.id = id;
        this.id_user = id_user;
        this.num = num;
        this.role = role;
        this.location = location;
        this.document = document;
    }

    public Application(double id_user, double num, String role, String location, String document) {
        this.id_user = id_user;
        this.num = num;
        this.role = role;
        this.location = location;
        this.document = document;
    }

    public double getId() {
        return id;
    }

    public void setId(double id) {
        this.id = id;
    }

    public double getId_user() {
        return id_user;
    }

    public void setId_user(double id_user) {
        this.id_user = id_user;
    }

    public double getNum() {
        return num;
    }

    public void setNum(double num) {
        this.num = num;
    }

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }

    public String getLocation() {
        return location;
    }

    public void setLocation(String location) {
        this.location = location;
    }

    public String getDocument() {
        return document;
    }

    public void setDocument(String document) {
        this.document = document;
    }

   
}
