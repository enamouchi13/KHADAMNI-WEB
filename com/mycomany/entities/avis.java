/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycomany.entities;

/**
 *
 * @author Mariem
 */
public class avis {
    
    
    private int id;
    private Utilisateur user;    // creation d un objet appl user pour faire la jointure et dans le service je l'identifie avec la bd pour qu'il se connait comme cin //
    private String role,nv_satif, comment;

    public avis(int id, Utilisateur user, String role, String nv_satif, String comment) {
        this.id = id;
        this.user = user;
        this.role = role;
        this.nv_satif = nv_satif;
        this.comment = comment;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public Utilisateur getUser() {
        return user;
    }

    public void setUser(Utilisateur user) {
        this.user = user;
    }

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }

    public String getNv_satif() {
        return nv_satif;
    }

    public void setNv_satif(String nv_satif) {
        this.nv_satif = nv_satif;
    }

    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }

    @Override
    public String toString() {
        return "avis{" + "id=" + id + ", user=" + user + ", role=" + role + ", nv_satif=" + nv_satif + ", comment=" + comment + '}';
    }
    
    
    
    
}